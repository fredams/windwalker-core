<?php
/**
 * Part of Phoenix project.
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Windwalker\Core\Asset;

use Windwalker\Core\Facade\AbstractProxyFacade;

/**
 * The Asset class.
 *
 * @see AssetManager
 *
 * @method  static  AssetManager  addStyle()                addStyle($url, $version = null, $attribs = array())
 * @method  static  AssetManager  addScript()               addScript($url, $version = null, $attribs = array())
 * @method  static  AssetManager  internalStyle()           internalStyle($content)
 * @method  static  AssetManager  internalScript()          internalScript($content)
 * @method  static  AssetManager  addCSS()                  addCSS($url, $version = null, $attribs = array())
 * @method  static  AssetManager  addJS()                   addJS($url, $version = null, $attribs = array())
 * @method  static  AssetManager  internalCSS()             internalCSS($content)
 * @method  static  AssetManager  internalJS()              internalJS($content)
 * @method  static  string        renderStyles()            renderStyles($withInternal = false)
 * @method  static  string        renderScripts()           renderScripts($withInternal = false)
 * @method  static  string        renderInternalStyles()    renderInternalStyles()
 * @method  static  string        renderInternalScripts()   renderInternalScripts()
 * @method  static  string        getVersion()              getVersion()
 * @method  static  AssetManager  setIndents()              setIndents(string $indents)
 * @method  static  string        getIndents()              getIndents()
 * @method  static  AssetTemplate getTemplate()             getTemplate()
 * @method  static  string        setTemplate()             setTemplate(AssetTemplate $template)
 * @method  static  string        getJSObject()             getJSObject(array $array)
 * @method  static  string        path()                    path()
 * @method  static  string        root()                    root()
 *
 * @since  1.0
 */
abstract class Asset extends AbstractProxyFacade
{
	/**
	 * Property key.
	 *
	 * @var  string
	 */
	protected static $_key = 'asset';
}
