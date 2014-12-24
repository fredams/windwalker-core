<?php
/**
 * Part of auth project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Windwalker\Core\View\Twig;

use Windwalker\Core\View\Helper\ViewHelper;

/**
 * Class FormosaExtension
 *
 * @since 1.0
 */
class WindwalkerExtension extends \Twig_Extension
{
	/**
	 * Returns the name of the extension.
	 *
	 * @return string The extension name
	 */
	public function getName()
	{
		return 'windwalker';
	}

	/**
	 * getGlobals
	 *
	 * @return  array
	 */
	public function getGlobals()
	{
		return ViewHelper::getGlobalVariables();
	}

	/**
	 * getFunctions
	 *
	 * @return  array
	 */
	public function getFunctions()
	{
		return array(
			new \Twig_SimpleFunction('show', 'show')
		);
	}
}
 