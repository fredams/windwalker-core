<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Windwalker\Core\Console;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Windwalker\Console\Console;
use Windwalker\Core\Application\WebApplication;
use Windwalker\Core\Asset\AssetProvider;
use Windwalker\Core\Event\EventDispatcher;
use Windwalker\Core\Ioc;
use Windwalker\Core\Package\PackageHelper;
use Windwalker\Core\Package\PackageResolver;
use Windwalker\Core\Provider\RendererProvider;
use Windwalker\Core\Provider\RouterProvider;
use Windwalker\Core\Router\MainRouter;
use Windwalker\Http\Output\NoHeaderOutput;
use Windwalker\Http\Request\ServerRequestFactory;
use Windwalker\Http\WebHttpServer;
use Windwalker\Structure\Structure;
use Windwalker\Uri\UriData;

/**
 * The ConsoleHelper class.
 *
 * @since  3.0
 */
class ConsoleHelper
{
    /**
     * loadPackages
     *
     * @param string      $env
     * @param CoreConsole $console
     *
     * @return array
     */
    public static function loadPackages($env = 'dev', CoreConsole $console = null)
    {
        $console = $console ?: Ioc::getApplication();

        return (array) (new Structure())
            ->loadFile($console->get('path.etc') . '/app/console.php', 'php')
            ->loadFile($console->get('path.etc') . '/app/' . $env . '.php', 'php')
            ->get('packages');
    }

    /**
     * getAllPackagesResolver
     *
     * @param string      $env
     * @param CoreConsole $console
     *
     * @return  PackageResolver
     * @throws \ReflectionException
     * @throws \Windwalker\DI\Exception\DependencyResolutionException
     */
    public static function getAllPackagesResolver($env = 'dev', CoreConsole $console = null)
    {
        $console = $console ?: Ioc::getApplication();

        $container = clone $console->container;
        $container->share(EventDispatcher::class, $container->newInstance(EventDispatcher::class));

        $resolver = new PackageResolver($container);

        foreach (static::loadPackages($env, $console) as $name => $package) {
            $resolver->addPackage($name, $package);
        }

        return $resolver;
    }

    /**
     * executeWeb
     *
     * @param Request $request
     * @param array   $config
     * @param string  $appClass
     *
     * @return  Response
     * @throws \ReflectionException
     * @throws \Windwalker\DI\Exception\DependencyResolutionException
     */
    public static function executeWeb(Request $request, $config = [], $appClass = 'Windwalker\Web\Application')
    {
        $profile = Ioc::getProfile();

        Ioc::setProfile('web');

        if (!class_exists($appClass)) {
            throw new \LogicException($appClass . ' not found, you have to provide an exists Application class name.');
        }

        if (!is_subclass_of($appClass, WebApplication::class)) {
            throw new \LogicException('Application class should be sub class of ' . WebApplication::class);
        }

        /** @var WebApplication $app */
        $app = new $appClass($request);

        $app->getConfig()->load($config);

        $app->set('output.return_body', true);

        $app->server->setOutput(new NoHeaderOutput());

        $response = $app->execute();

        Ioc::setProfile($profile);

        return $response;
    }

    /**
     * Execute a package in CLI environment.
     *
     * @param string  $package
     * @param string  $task
     * @param Request $request
     * @param array   $config
     * @param string  $appClass
     *
     * @return Response
     * @throws \ReflectionException
     * @throws \Windwalker\DI\Exception\DependencyResolutionException
     */
    public static function executePackage(
        $package,
        $task,
        Request $request,
        $config = [],
        $appClass = 'Windwalker\Web\Application'
    ) {
        $profile = Ioc::getProfile();

        Ioc::setProfile('web');

        if (!class_exists($appClass)) {
            throw new \LogicException($appClass . ' not found, you have to provide an exists Application class name.');
        }

        if (!is_subclass_of($appClass, WebApplication::class)) {
            throw new \LogicException('Application class should be sub class of ' . WebApplication::class);
        }

        /** @var WebApplication $app */
        $app = new $appClass($request);
        $app->boot();
        $app->getRouter();

        $package = $app->getPackage($package);

        $container = $app->getContainer();

        $container->share('current.package', $package);
        $container->get('config')->load($config);

        $response = $package->execute($task, $request, new \Windwalker\Http\Response\Response());

        Ioc::setProfile($profile);

        return $response;
    }

    /**
     * prepareWebEnvironment
     *
     * @param string $env
     * @param string $url
     * @param string $script
     * @param array  $routeFiles
     *
     * @return  void
     * @throws \ReflectionException
     * @throws \Windwalker\DI\Exception\DependencyResolutionException
     */
    public static function prepareWebEnvironment($env = 'web', $url = '', $script = null, $routeFiles = [])
    {
        $container = Ioc::factory();
        $app       = $container->get('app');

        if (!$app instanceof Console) {
            return;
        }

        // Prepare server and uri object
        $server = new WebHttpServer(null, ServerRequestFactory::createFromUri($url, $script));

        $container->share(UriData::class, $server->getUriData())->alias('uri', UriData::class);

        // Register providers
        $container->registerServiceProvider($container->newInstance(RouterProvider::class))
            ->registerServiceProvider($container->newInstance(RendererProvider::class))
            ->registerServiceProvider($container->newInstance(AssetProvider::class));

        // Prepare routers
        /** @var MainRouter $router */
        $router   = $container->get('router');
        $resolver = static::getAllPackagesResolver($env);

        $router->setPackageResolver($resolver);

        foreach ($routeFiles as $routeFile) {
            $router->register($routeFile);
        }
    }
}
