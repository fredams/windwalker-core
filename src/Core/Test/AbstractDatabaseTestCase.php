<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Windwalker\Core\Test;

use Windwalker\Core\Ioc;
use Windwalker\Database\Driver\DatabaseDriver;
use Windwalker\Database\Test\DsnResolver;

/**
 * The AbstractDatabaseTestCase class.
 * 
 * @since  2.0
 */
class AbstractDatabaseTestCase extends AbstractBaseTestCase
{
	/**
	 * Property db.
	 *
	 * @var  DatabaseDriver
	 */
	protected static $dbo = null;

	/**
	 * Property db.
	 *
	 * @var  DatabaseDriver
	 */
	protected $db = null;

	/**
	 * Property driver.
	 *
	 * @var string
	 */
	protected static $driver = null;

	/**
	 * Property quote.
	 *
	 * @var  array
	 */
	protected static $quote = array('"', '"');

	/**
	 * Property dbname.
	 *
	 * @var string
	 */
	protected static $dbname = '';

	/**
	 * Property dsn.
	 *
	 * @var array
	 */
	protected static $dsn = array();

	/**
	 * setUpBeforeClass
	 *
	 * @throws \LogicException
	 * @return  void
	 */
	public static function setUpBeforeClass()
	{
		$config = Ioc::getConfig();

		static::$dsn = $dsn = $config['database.dsn'];
		static::$dbname = $dbname = $dsn['dbname'];

		// Id db exists, return.
		if (static::$dbo)
		{
			static::$dbo->select($dbname);

			return;
		}

		// Use factory create dbo, only create once and will be singleton.
		$db = Ioc::getDatabase();

		$db->getDatabase($dbname)->create(true);

		$db->select($dbname);

		$queries = file_get_contents(__DIR__ . '/Stub/' . static::$driver . '.sql');

		$queries = $db->splitSql($queries);

		foreach ($queries as $query)
		{
			$query = trim($query);

			if ($query)
			{
				$db->setQuery($query)->execute();
			}
		}

		static::$dbo = $db;
	}

	/**
	 * tearDownAfterClass
	 *
	 * @return  void
	 */
	public static function tearDownAfterClass()
	{
		if (!static::$dbo)
		{
			return;
		}

		static::$dbo->setQuery('DROP DATABASE IF EXISTS ' . self::$dbo->quoteName(static::$dbname))->execute();

		static::$dbo = null;
	}

	/**
	 * Destruct.
	 */
	public function __destruct()
	{
		if (!static::$dbo)
		{
			return;
		}

		static::$dbo->setQuery('DROP DATABASE IF EXISTS ' . self::$dbo->quoteName(static::$dbname))->execute();

		static::$dbo = null;
	}

	/**
	 * Sets up the fixture.
	 *
	 * This method is called before a test is executed.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	protected function setUp()
	{
		if (empty(static::$dbo))
		{
			$this->markTestSkipped('There is no database driver.');
		}

		parent::setUp();
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		$this->db = null;
	}
}