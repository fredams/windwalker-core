<?php
/**
 * Part of starter project.
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Windwalker\Core\Facade;

/**
 * The AbstractProxyFacade class.
 *
 * @since  {DEPLOY_VERSION}
 */
abstract class AbstractProxyFacade extends AbstractFacade
{
	/**
	 * Handle dynamic, static calls to the object.
	 *
	 * @param   string  $method  The method name.
	 * @param   array   $args    The arguments of method call.
	 *
	 * @return  mixed
	 */
	public static function __callStatic($method, $args)
	{
		$instance = static::getInstance();

		switch (count($args))
		{
			case 0:
				return $instance->$method();
			case 1:
				return $instance->$method($args[0]);
			case 2:
				return $instance->$method($args[0], $args[1]);
			case 3:
				return $instance->$method($args[0], $args[1], $args[2]);
			case 4:
				return $instance->$method($args[0], $args[1], $args[2], $args[3]);
			default:
				return call_user_func_array(array($instance, $method), $args);
		}
	}
}
