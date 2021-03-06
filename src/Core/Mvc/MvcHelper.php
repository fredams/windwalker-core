<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2014 - 2016 LYRASOFT. All rights reserved.
 * @license    GNU Lesser General Public License version 3 or later.
 */

namespace Windwalker\Core\Mvc;

/**
 * The MvcHelper class.
 *
 * @since  2.1.5.8
 */
abstract class MvcHelper
{
    /**
     * guessName
     *
     * @param string|object $class
     * @param int           $backwards
     * @param string        $default
     *
     * @return  string
     */
    public static function guessName($class, $backwards = 2, $default = 'default')
    {
        if (!is_string($class)) {
            $class = get_class($class);
        }

        $class = explode('\\', $class);

        $name = null;

        foreach (range(1, $backwards) as $i) {
            $name = array_pop($class);
        }

        $name = $name ?: $default;

        return strtolower($name);
    }

    /**
     * guessPackage
     *
     * @param string|object $class
     * @param int           $backwards
     * @param string        $default
     *
     * @return  string
     */
    public static function guessPackage($class, $backwards = 4, $default = null)
    {
        return static::guessName($class, $backwards, $default);
    }

    /**
     * getPackageNamespace
     *
     * @param string|object $class
     * @param int           $backwards
     *
     * @return  string
     */
    public static function getPackageNamespace($class, $backwards = 3)
    {
        if (!is_string($class)) {
            $class = get_class($class);
        }

        $class = explode('\\', $class);

        foreach (range(1, $backwards) as $i) {
            array_pop($class);
        }

        return implode('\\', $class);
    }
}
