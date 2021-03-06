<?php
/**
 * Part of earth project.
 *
 * @copyright  Copyright (C) 2019 .
 * @license    LGPL-2.0-or-later
 */

namespace Windwalker\Core\Application;

use Windwalker\DI\Container;

/**
 * The ServiceAwareTrait class.
 *
 * @since  3.5.5
 */
trait ServiceAwareTrait
{
    /**
     * make
     *
     * @param string $class
     * @param array  $args
     * @param bool   $protected
     *
     * @return  mixed
     *
     * @since  3.5
     */
    public function make(string $class, array $args = [], bool $protected = false)
    {
        /** @var Container $container */
        $container = $this->getContainer();

        return $container->createSharedObject($class, $args, $protected);
    }

    /**
     * service
     *
     * @param string $class
     * @param bool   $forceNew
     *
     * @return  mixed
     *
     * @since  3.5
     */
    public function service(string $class, bool $forceNew = false)
    {
        /** @var Container $container */
        $container = $this->getContainer();

        if (!$forceNew && $container->has($class)) {
            return $container->get($class);
        }

        return $container->createSharedObject($class);
    }
}
