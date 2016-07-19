<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Windwalker\Core\Package\Resolver;

use Windwalker\Core\Database\NullRecord;
use Windwalker\Core\Object\NullObject;
use Windwalker\Record\Record;

/**
 * The RecordResolver class.
 *
 * @method  static  Record  create($name, ...$args)
 * @method  static  Record  getInstance($name, $args = array(), $forceNew = false)
 *
 * @since  1.0
 */
class RecordResolver extends AbstractPackageObjectResolver
{
	/**
	 * createObject
	 *
	 * @param  string $class
	 * @param  array  $args
	 *
	 * @return Record
	 * @throws \Exception
	 */
	protected static function createObject($class, ...$args)
	{
		if (!is_subclass_of($class, Record::class))
		{
			throw new \InvalidArgumentException(sprintf('Class: %s is not sub class of ' . Record::class, $class));
		}

		// TODO: Make Record support set DB after construct.
		try
		{
			return new $class(...$args);
		}
		catch (\Exception $e)
		{
			if ($e instanceof \InvalidArgumentException || $e->getPrevious() instanceof \PDOException)
			{
				return new NullRecord;
			}

			throw $e;
		}
	}

	/**
	 * getClass
	 *
	 * @param string $name
	 *
	 * @return  string
	 */
	public static function getClass($name)
	{
		return ucfirst($name) . 'Record';
	}
}
