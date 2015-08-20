<?php
/**
 * Part of Windwalker project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Windwalker\Debugger\View\Routing;

use Windwalker\Data\Data;
use Windwalker\Data\DataSet;
use Windwalker\Debugger\View\AbstractDebuggerHtmlView;
use Windwalker\Router\Route;
use Windwalker\String\StringHelper;

/**
 * The SystemHtmlView class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class RoutingHtmlView extends AbstractDebuggerHtmlView
{
	/**
	 * prepareData
	 *
	 * @param \Windwalker\Data\Data $data
	 *
	 * @return  void
	 */
	protected function prepareData($data)
	{
		$data->collector = $data->item['collector'];
		$data->routes = new DataSet;
		$data->matchedRoute = new Data($data->collector['routing.matched']);

		foreach ((array) $data->collector['routing.routes'] as $name => $route)
		{
			$route = new Data($route);

			list($packageName, $routeName) = StringHelper::explode(':', $route->name, 2, 'array_unshift');

			$route->package = $packageName;
			$route->matched = $route->name == $data->matchedRoute->name;

			$data->routes[] = $route;
		}

		// Controller
		$data->controller = $data->collector['controller.main'];
	}
}
