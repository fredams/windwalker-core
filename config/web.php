<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

use Windwalker\Utilities\Arr;

return Arr::mergeRecursive(
    include __DIR__ . '/windwalker.php',
    [
        'packages' => [

        ],

        'providers' => [
            'web'      => \Windwalker\Core\Provider\WebProvider::class,
            'error'    => \Windwalker\Core\Error\ErrorHandlingProvider::class,
            'logger'   => \Windwalker\Core\Provider\LoggerProvider::class,
            'event'    => \Windwalker\Core\Provider\EventProvider::class,
            'database' => \Windwalker\Core\Provider\DatabaseProvider::class,
            'router'   => \Windwalker\Core\Provider\RouterProvider::class,
            'lang'     => \Windwalker\Core\Provider\LanguageProvider::class,
            'renderer' => \Windwalker\Core\Provider\RendererProvider::class,
            'cache'    => \Windwalker\Core\Provider\CacheProvider::class,
            'session'  => \Windwalker\Core\Provider\SessionProvider::class,
            'auth'     => \Windwalker\Core\Provider\UserProvider::class,
            'security' => \Windwalker\Core\Provider\SecurityProvider::class,
            'asset'    => \Windwalker\Core\Asset\AssetProvider::class,
            'mailer'   => \Windwalker\Core\Mailer\MailerProvider::class,
            'mailer_adapter' => \Windwalker\Core\Mailer\SwiftMailerProvider::class,
            'queue'    => \Windwalker\Core\Queue\QueueProvider::class,
            'faker'  => \Windwalker\Core\Provider\FakerProvider::class,
        ],

        'routing' => [
            'files' => [

            ]
        ],

        'middlewares' => [
            800  => \Windwalker\Core\Application\Middleware\SessionRaiseMiddleware::class,
            900  => \Windwalker\Core\Application\Middleware\RoutingMiddleware::class,
        ],

        'configs' => [
        ],

        'listeners' => [

        ]
    ]
);
