<?php
/**
 * Part of formosa project.
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Windwalker\Core\View\Helper;

use Windwalker\Core\View\Helper\Set\HelperSet;

/**
 * Class AbstractHelper
 *
 * @since 1.0
 */
class AbstractHelper
{
	/**
	 * Property parent.
	 *
	 * @var  HelperSet
	 */
	protected $parent = null;

	/**
	 * Class init.
	 *
	 * @param HelperSet $parent
	 */
	public function __construct(HelperSet $parent = null)
	{
		$this->parent = $parent;
	}

	/**
	 * Method to get property Parent
	 *
	 * @return  HelperSet
	 */
	public function getParent()
	{
		return $this->parent;
	}

	/**
	 * Method to set property parent
	 *
	 * @param   HelperSet $parent
	 *
	 * @return  static  Return self to support chaining.
	 */
	public function setParent($parent)
	{
		$this->parent = $parent;

		return $this;
	}
}
 