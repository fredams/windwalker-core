<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2014 - 2015 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Windwalker\Debugger\Helper;

use Windwalker\Core\Ioc;
use Windwalker\Structure\Structure;
use Windwalker\Utilities\ArrayHelper;

/**
 * The ComposerInformation class.
 *
 * @since  2.1.1
 */
class ComposerInformation
{
    /**
     * Property cache.
     *
     * @var  Structure
     */
    protected static $lock;

    /**
     * Property json.
     *
     * @var Structure
     */
    protected static $json;

    /**
     * getLock
     *
     * @return  Structure
     */
    public static function getLock()
    {
        if (!static::$lock) {
            $root = Ioc::getConfig()->get('path.root');
            $file = realpath($root . '/composer.lock');

            $data = file_get_contents($file);
            $data = json_decode($data);

            static::$lock = new Structure($data);
        }

        return static::$lock;
    }

    /**
     * getJson
     *
     * @return  Structure
     */
    public static function getJson()
    {
        if (!static::$json) {
            $root = Ioc::getConfig()->get('path.root');
            $file = realpath($root . '/composer.json');

            static::$json = new Structure(is_file($file) ? file_get_contents($file) : null);
        }

        return static::$json;
    }

    /**
     * getInstalledVersion
     *
     * @param   string $package
     *
     * @return  string
     */
    public static function getInstalledVersion($package)
    {
        $composer = ComposerInformation::getLock();

        $data = ArrayHelper::query($composer['packages'], ['name' => $package]);

        if (isset($data[0]['version'])) {
            return $data[0]['version'];
        }

        return null;
    }
}
