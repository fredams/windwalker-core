<?php
/**
 * Part of phoenix project.
 *
 * @copyright  Copyright (C) 2017 LYRASOFT.
 * @license    LGPL-2.0-or-later
 */

namespace Windwalker\Core\Database\Traits;

/**
 * The DateFormatTrait class.
 *
 * @since  3.2
 */
trait DateFormatTrait
{
    /**
     * getDateFormat
     *
     * @return  string
     */
    public function getDateFormat()
    {
        return $this->db->getQuery(true)->getDateFormat();
    }

    /**
     * getNullDate
     *
     * @return  string
     */
    public function getNullDate()
    {
        return $this->db->getQuery(true)->getNullDate();
    }
}
