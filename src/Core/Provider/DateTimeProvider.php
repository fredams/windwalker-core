<?php
/**
 * Part of starter project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Windwalker\Core\Provider;

use Joomla\DateTime\DateTime;
use Windwalker\DI\Container;
use Windwalker\DI\ServiceProviderInterface;

/**
 * The DateTimeProvider class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class DateTimeProvider implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container $container The DI container.
	 *
	 * @return  void
	 */
	public function register(Container $container)
	{
		$closure = function(Container $container)
		{
			$tz = $container->get('system.config')->get('system.timezone', 'UTC');

			return new DateTime('now', new \DateTimeZone($tz));
		};

		$container->set('datetime', $closure)
			->alias('date', 'datetime');
	}
}
