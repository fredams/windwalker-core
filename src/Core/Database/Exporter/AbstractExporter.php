<?php
/**
 * Part of starter project.
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Windwalker\Core\Database\Exporter;

use Windwalker\Core\Model\DatabaseModel;

/**
 * The AbstractExporter class.
 *
 * @since  {DEPLOY_VERSION}
 */
abstract class AbstractExporter extends DatabaseModel
{
	/**
	 * export
	 *
	 * @return mixed|string
	 */
	abstract public function export();

	/**
	 * getCreateTable
	 *
	 * @param string $table
	 *
	 * @return array|mixed|string
	 */
	abstract protected function getCreateTable($table);

	/**
	 * getInserts
	 *
	 * @param string $table
	 *
	 * @return mixed|null|string
	 */
	abstract protected function getInserts($table);
}