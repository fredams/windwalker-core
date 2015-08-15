<?php
/**
 * Part of Windwalker project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Windwalker\Core\Listener;

use Windwalker\Core\Controller\Controller;
use Windwalker\Core\DateTime\DateTime;
use Windwalker\Core\Package\AbstractPackage;
use Windwalker\Core\Router\RestfulRouter;
use Windwalker\Data\Data;
use Windwalker\Data\DataSet;
use Windwalker\DI\Container;
use Windwalker\Event\Event;
use Windwalker\Profiler\Point\Collector;
use Windwalker\Profiler\Profiler;

/**
 * The ProfilerListender class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class ProfilerListener
{
	/**
	 * onAfterInitialise
	 *
	 * @param Event $event
	 *
	 * @return  void
	 */
	public function onAfterInitialise(Event $event)
	{
		/**
		 * @var Container $container
		 * @var Collector $collector
		 * @var Profiler  $profiler
		 */
		$container = $event['app']->getContainer();
		$collector = $container->get('system.collector');
		$profiler  = $container->get('system.profiler');

		$collector['time'] = DateTime::create('now', DateTime::TZ_LOCALE);

		$profiler->mark(__FUNCTION__, array(
			'tag' => 'system.process'
		));
	}

	/**
	 * onAfterRouting
	 *
	 * @param Event $event
	 *
	 * @return  void
	 */
	public function onAfterRouting(Event $event)
	{
		/**
		 * @var Container $container
		 * @var Collector $collector
		 * @var Profiler  $profiler
		 */
		$container = $event['app']->getContainer();
		$collector = $container->get('system.collector');
		$profiler  = $container->get('system.profiler');

		/** @var RestfulRouter $router */
		$router = $event['app']->getRouter();

		$collector['route.matched'] = $container->get('current.route');
		$collector['routes']        = $router->getRoutes();
		$collector['package']       = $container->get('current.package')->getName();
		$collector['package.class'] = get_class($container->get('current.package'));

		$profiler->mark(__FUNCTION__, array(
			'tag' => 'system.process'
		));
	}

	/**
	 * onAfterPackageExecute
	 *
	 * @param Event $event
	 *
	 * @return  void
	 */
	public function onAfterPackageExecute(Event $event)
	{
		/**
		 * @var AbstractPackage $package
		 * @var Controller      $controller
		 */
		$package = $event['package'];
		$controller = $event['controller'];

		/**
		 * @var Container $container
		 * @var Collector $collector
		 * @var Profiler  $profiler
		 */
		$container = $package->getContainer();
		$collector = $container->get('system.collector');
		$profiler  = $container->get('system.profiler');

		if (!$collector['controllers'])
		{
			$collector['controllers'] = new DataSet;
		}

		$collector['controllers'][] = new Data(array(
			'controller' => get_class($controller),
			'task'       => $event['task'],
			'input'      => $controller->getInput()->getArray(),
			'variables'  => $event['variables'],
		));

		$profiler->mark(__FUNCTION__, array(
			'tag' => 'package.process'
		));
	}

	public function onAfterRender(Event $event)
	{
		/**
		 * @var Container $container
		 * @var Collector $collector
		 * @var Profiler  $profiler
		 */
		$container = $event['app']->getContainer();
		$collector = $container->get('system.collector');
		$profiler  = $container->get('system.profiler');
	}
}
