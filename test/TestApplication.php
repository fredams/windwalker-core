<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2014 - 2015 LYRASOFT. All rights reserved.
 * @license    GNU Lesser General Public License version 3 or later.
 */

namespace Windwalker\Core\Test;

use Windwalker\Core\Application\WebApplication;
use Windwalker\Core\Error\ErrorHandler;
use Windwalker\Core\Ioc;
use Windwalker\Core\Provider\AuthenticateProvider;
use Windwalker\Core\Provider\CacheProvider;
use Windwalker\Core\Provider\DatabaseProvider;
use Windwalker\Core\Provider\EventProvider;
use Windwalker\Core\Provider\LanguageProvider;
use Windwalker\Core\Provider\RouterProvider;
use Windwalker\Core\Provider\SessionProvider;
use Windwalker\Core\Provider\WhoopsProvider;
use Windwalker\Core\Test\Mvc\MvcPackage;
use Windwalker\Core\Windwalker;
use Windwalker\Database\Test\DsnResolver;
use Windwalker\DI\ServiceProviderInterface;
use Windwalker\Registry\Registry;

/**
 * The TestApplication class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class TestApplication extends WebApplication
{
	/**
	 * initialise
	 *
	 * @return  void
	 */
	protected function initialise()
	{
		Windwalker::prepareSystemPath($this->config);

		parent::initialise();

		ErrorHandler::restore();

		// Resolve DB info
		$dsn = DsnResolver::getDsn($this->get('database.driver'));

		$this->config['database.host'] = $dsn['host'];
		// $this->config['database.name'] = $dsn['dbname'];
		$this->config['database.user'] = $dsn['user'];
		$this->config['database.password'] = $dsn['pass'];
		$this->config['database.prefix'] = $dsn['prefix'];
		$this->config['database.dsn'] = $dsn;

		// Start session
		Ioc::getSession();
	}

	/**
	 * loadProviders
	 *
	 * @return  ServiceProviderInterface[]
	 */
	public function loadProviders()
	{
		$providers = parent::loadProviders();

		/*
		 * Default Providers:
		 * -----------------------------------------
		 * This is some default service providers, we don't recommend to remove them,
		 * But you can replace with yours, Make sure all the needed container key has
		 * registered in your own providers.
		 */
		// $providers['debug']    = new WhoopsProvider;
		$providers['event']    = new EventProvider;
		$providers['database'] = new DatabaseProvider;
		$providers['router']   = new RouterProvider;
		$providers['lang']     = new LanguageProvider;
		$providers['cache']    = new CacheProvider;
		$providers['session']  = new SessionProvider;
		$providers['auth']     = new AuthenticateProvider;

		/*
		 * Custom Providers:
		 * -----------------------------------------
		 * You can add your own providers here. If you installed a 3rd party packages from composer,
		 * but this package need some init logic, create a service provider to do this and register it here.
		 */

		// Custom Providers here...

		return $providers;
	}

	/**
	 * getPackages
	 *
	 * @return  array
	 */
	public function loadPackages()
	{
		/*
		 * Get Global Packages
		 * -----------------------------------------
		 * If you want a package can be use in every applications (for example: Web and Console),
		 * set it in Windwalker\Windwalker object.
		 */
		$packages = Windwalker::loadPackages();

		/*
		 * Get Packages for This Application
		 * -----------------------------------------
		 * If you want a package only use in this application or want to override a global package,
		 * set it here. Example: $packages[] = new Flower\FlowerPackage;
		 */

		// Your packages here...
		// $packages['mvc'] = new MvcPackage;

		return $packages;
	}

	/**
	 * Prepare execute hook.
	 *
	 * @return  void
	 */
	protected function prepareExecute()
	{
	}

	/**
	 * Pose execute hook.
	 *
	 * @return  mixed
	 */
	protected function postExecute()
	{
	}

	/**
	 * loadConfiguration
	 *
	 * @param Registry $config
	 *
	 * @throws  \RuntimeException
	 * @return  void
	 */
	protected function loadConfiguration(Registry $config)
	{
		Windwalker::loadConfiguration($config);
	}

	/**
	 * loadRoutingConfiguration
	 *
	 * @return  mixed
	 */
	protected function loadRoutingConfiguration()
	{
		return Windwalker::loadRouting();
	}
}
