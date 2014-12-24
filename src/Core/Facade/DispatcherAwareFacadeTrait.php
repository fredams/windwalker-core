<?php
/**
 * Part of starter project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Windwalker\Core\Facade;

use Windwalker\Core\Event\DispatcherAwareStaticTrait;
use Windwalker\Event\Dispatcher;
use Windwalker\Core\Ioc;

/**
 * The DispatcherAwareStaticTrait class.
 * 
 * @since  {DEPLOY_VERSION}
 */
trait DispatcherAwareFacadeTrait
{
	use DispatcherAwareStaticTrait

	/**
	 * Method to get property Dispatcher
	 *
	 * @return  Dispatcher
	 */
	public static function getDispatcher()
	{
		if (!static::$dispatcher)
		{
			static::$dispatcher = Ioc::getDispatcher();
		}

		return static::$dispatcher;
	}
}
