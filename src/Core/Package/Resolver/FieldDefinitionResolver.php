<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

namespace Windwalker\Core\Package\Resolver;

use Windwalker\Form\FieldDefinitionInterface;

/**
 * The FormDefinitionResolver class.
 *
 * @since  3.0
 */
class FieldDefinitionResolver extends AbstractPackageObjectResolver
{
    /**
     * createObject
     *
     * @param  string $class
     * @param  array  $args
     *
     * @return FieldDefinitionInterface
     * @throws \InvalidArgumentException
     */
    protected static function createObject($class, ...$args)
    {
        if (!is_subclass_of($class, FieldDefinitionInterface::class)) {
            throw new \InvalidArgumentException(sprintf(
                'Class: %s is not sub class of Windwalker\Form\FieldDefinitionInterface',
                $class
            ));
        }

        return new $class(...$args);
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
        return ucfirst($name) . 'Definition';
    }
}
