<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2014 - 2015 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Windwalker\Debugger\Helper;

use Windwalker\Core\Facade\AbstractFacade;
use Windwalker\Dom\HtmlElement;
use Windwalker\Profiler\Point\Collector;
use Windwalker\Utilities\ArrayHelper;

/**
 * The DebuggerHelper class.
 *
 * @method  static  Collector  getInstance()
 * 
 * @since  2.1.1
 */
abstract class DebuggerHelper extends AbstractFacade
{
	/**
	 * Property _key.
	 *
	 * @var  string
	 */
	protected static $_key = 'system.collector';

	/**
	 * addData
	 *
	 * @param   string $key
	 * @param   mixed  $value
	 * @param   int    $depth
	 */
	public static function addCustomData($key, $value, $depth = 5)
	{
		try
		{
			$collector = static::getInstance();
		}
		catch (\UnexpectedValueException $e)
		{
			return;
		}

		$data = $collector['custom.data'];

		if ($data === null)
		{
			$data = array();
		}

		if (is_array($value) || is_object($value))
		{
			$value = new HtmlElement('pre', ArrayHelper::dump($value, $depth));
		}

		$data[$key] = $value;

		$collector['custom.data'] = $data;
	}

	/**
	 * getQueries
	 *
	 * @return  array
	 */
	public static function getQueries()
	{
		$collector = static::getInstance();

		return $collector['database.queries'];
	}
}
