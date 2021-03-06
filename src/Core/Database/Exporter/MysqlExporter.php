<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2014 - 2016 LYRASOFT. All rights reserved.
 * @license    GNU Lesser General Public License version 3 or later.
 */

namespace Windwalker\Core\Database\Exporter;

use Windwalker\Core\Database\TableHelper;
use Windwalker\Query\Mysql\MysqlGrammar;

/**
 * The Exporter class.
 *
 * @since  2.1.1
 */
class MysqlExporter extends AbstractExporter
{
    /**
     * export
     *
     * @return mixed|string
     */
    public function export()
    {
        $tables = $this->db->getDatabase()->getTables(true);

        $sql = [];

        foreach ($tables as $table) {
            // Table
            $sql[] = MysqlGrammar::dropTable($table, true);
            $sql[] = $this->getCreateTable($table);

            // Data
            $inserts = $this->getInserts($table);

            if ($inserts) {
                $sql[] = $inserts;
            }
        }

        return implode(";\n\n", $sql);
    }

    /**
     * getCreateTable
     *
     * @param $table
     *
     * @return array|mixed|string
     */
    protected function getCreateTable($table)
    {
        $db = $this->db;

        $result = $db->getReader('SHOW CREATE TABLE ' . $this->db->quoteName($table))->loadArray();

        $sql = preg_replace('#AUTO_INCREMENT=\S+#is', '', $result[1]);

        $sql = explode("\n", $sql);

        $tableStriped = TableHelper::stripPrefix($result[0], $db->getPrefix());

        $sql[0] = str_replace($result[0], $tableStriped, $sql[0]);

        $sql = implode("\n", $sql);

        return $sql;
    }

    /**
     * getInserts
     *
     * @param $table
     *
     * @return mixed|null|string
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    protected function getInserts($table)
    {
        $db       = $this->db;
        $query    = $db->getQuery(true);
        $iterator = $db->getReader($query->select('*')->from($query->quoteName($table)))->getIterator();

        if (!count($iterator)) {
            return null;
        }

        $sql = [];

        foreach ($iterator as $data) {
            $data = (array) $data;

            $data = array_map(
                function ($d) use ($query) {
                    return $query->q($d) ?: 'NULL';
                },
                $data
            );

            $value = implode(', ', $data);

            $sql[] = (string) sprintf("INSERT `%s` VALUES (%s)", $table, $value);
        }

        return (string) implode(";\n", $sql);
    }
}
