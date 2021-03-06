<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2014 - 2016 LYRASOFT. All rights reserved.
 * @license    GNU Lesser General Public License version 3 or later.
 */

namespace Windwalker\Core\Provider;

use Windwalker\Core\Config\Config;
use Windwalker\Core\DateTime\Chronos;
use Windwalker\DI\Container;
use Windwalker\DI\ServiceProviderInterface;

/**
 * The DateTimeProvider class.
 *
 * @since  2.0
 */
class DateTimeProvider implements ServiceProviderInterface, BootableProviderInterface
{
    /**
     * boot
     *
     * @param Container $container
     *
     * @return  void
     */
    public function boot(Container $container)
    {
        $config = $container->get(Config::class);

        date_default_timezone_set($config->get('system.server_timezone') ?: 'UTC');
    }

    /**
     * Registers the service provider with a DI container.
     *
     * @param   Container $container The DI container.
     *
     * @return  void
     */
    public function register(Container $container)
    {
        $closure = function (Container $container) {
            $tz = $container->get('config')->get('system.timezone', 'UTC');

            return new Chronos('now', new \DateTimeZone($tz));
        };

        $container->set(Chronos::class, $closure);
    }
}
