<?php
/**
 * Part of Windwalker project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Windwalker\Core\Test\Integrate;

use Windwalker\Core\Test\AbstractBaseTestCase;
use Windwalker\Core\Package\AbstractPackage;
use Windwalker\Core\Package\NullPackage;
use Windwalker\Core\Test\Integrate\Controller\Stub\StubController;
use Windwalker\Core\Test\Integrate\View\Stub\StubHtmlView;
use Windwalker\Core\View\HtmlView;
use Windwalker\Filesystem\Path;
use Windwalker\Ioc;
use Windwalker\Test\TestHelper;

/**
 * The ControllerViewTest class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class ControllerViewTest extends AbstractBaseTestCase
{
	/**
	 * Property instance.
	 *
	 * @var StubController
	 */
	protected $instance;

	/**
	 * setUp
	 *
	 * @return  void
	 */
	public function setUp()
	{
		$this->instance = new StubController;

		$this->instance->setPackage(new IntegratePackage);
	}

	/**
	 * getController
	 *
	 * @param AbstractPackage $package
	 *
	 * @return  StubController
	 */
	protected function getController(AbstractPackage $package = null)
	{
		if ($package)
		{
			return new StubController(null, null, null, $package);
		}

		return new StubController;
	}

	/**
	 * getPackagePath
	 *
	 * @param AbstractPackage $package
	 *
	 * @return  string
	 */
	protected function getPath($package)
	{
		$ref = new \ReflectionClass($package);

		return dirname($ref->getFileName());
	}

	/**
	 * testGetViewNoPackage
	 *
	 * @return  void
	 */
	public function testGetViewNoPackage()
	{
		$controller = $this->getController();

		$view = $controller->getView();

		$this->assertTrue($view->getPackage() instanceof NullPackage);
		$this->assertEquals('stub', $view->getName());
		$this->assertEquals('integrate', $view->getPackage()->getName());

		$config = $view->getConfig();

		$this->assertEquals('stub', $config['name']);
		$this->assertEquals('integrate', $config['package.name']);
		$this->assertEquals($this->getPath($this->instance->getPackage()), Path::clean($config['package.path']));

		$paths = $view->getRegisteredPaths();

		$paths = array_values(iterator_to_array($paths));

		$this->assertPathEquals($this->getPath($this->instance->getPackage()) . '/Templates/stub', $paths[0]);
		$this->assertPathEquals(Ioc::getConfig()->get('path.templates') . '/integrate/stub', $paths[1]);
		$this->assertPathEquals(realpath(__DIR__ . '/../../src') . '/Core/Resources/Templates', $paths[2]);
		$this->assertPathEquals(Ioc::getConfig()->get('path.templates'), $paths[3]);

		$this->assertEquals('<h1>Flower</h1>', trim($view->setLayout('flower')->render()));
		$this->assertEquals('<h1>Test</h1>', trim($view->setLayout('test.test')->render()));
		$this->assertEquals('<h1>Test</h1>', trim($view->setLayout('_global.test')->render()));
	}

	/**
	 * testNewViewNoPackage
	 *
	 * @return  void
	 */
	public function testNewViewNoPackage()
	{
		$view = new StubHtmlView;

		$this->assertTrue($view->getPackage() instanceof NullPackage);
		$this->assertEquals('stub', $view->getName());
		$this->assertEquals('integrate', $view->getPackage()->getName());

		$config = $view->getConfig();

		$this->assertEquals(null, $config['name']);
		$this->assertEquals(null, $config['package.name']);
		// $this->assertEquals($this->getPackagePath($this->instance->getPackage()), Path::clean($config['package.path']));

		$paths = $view->getRegisteredPaths();

		$paths = array_values(iterator_to_array($paths));

		$this->assertPathEquals($this->getPath($view) . '/../../Templates/stub', $paths[0]);
		$this->assertPathEquals(Ioc::getConfig()->get('path.templates') . '/integrate/stub', $paths[1]);
		$this->assertPathEquals(realpath(__DIR__ . '/../../src') . '/Core/Resources/Templates', $paths[2]);
		$this->assertPathEquals(Ioc::getConfig()->get('path.templates'), $paths[3]);

		$this->assertEquals('<h1>Flower</h1>', trim($view->setLayout('flower')->render()));
		$this->assertEquals('<h1>Test</h1>', trim($view->setLayout('test.test')->render()));
		$this->assertEquals('<h1>Test</h1>', trim($view->setLayout('_global.test')->render()));
	}

	/**
	 * testGetViewWithPackage
	 *
	 * @return  void
	 */
	public function testGetViewWithPackage()
	{
		$controller = $this->instance;

		$view = $controller->getView(null, 'html', true);

		$this->assertTrue($view->getPackage() instanceof NullPackage);
		$this->assertEquals('stub', $view->getName());
		$this->assertEquals('integrate', $view->getPackage()->getName());

		$config = $view->getConfig();

		$this->assertEquals('stub', $config['name']);
		$this->assertEquals('integrate', $config['package.name']);
		$this->assertEquals($this->getPath($this->instance->getPackage()), Path::clean($config['package.path']));

		$paths = $view->getRegisteredPaths();

		$paths = array_values(iterator_to_array($paths));

		$this->assertPathEquals($this->getPath($this->instance->getPackage()) . '/Templates/stub', $paths[0]);
		$this->assertPathEquals(Ioc::getConfig()->get('path.templates') . '/integrate/stub', $paths[1]);
		$this->assertPathEquals(realpath(__DIR__ . '/../../src') . '/Core/Resources/Templates', $paths[2]);
		$this->assertPathEquals(Ioc::getConfig()->get('path.templates'), $paths[3]);

		$this->assertEquals('<h1>Flower</h1>', trim($view->setLayout('flower')->render()));
		$this->assertEquals('<h1>Test</h1>', trim($view->setLayout('test.test')->render()));
		$this->assertEquals('<h1>Test</h1>', trim($view->setLayout('_global.test')->render()));
	}

	/**
	 * testNewViewWithPackage
	 *
	 * @return  void
	 */
	public function testNewViewWithPackage()
	{
		$view = new StubHtmlView;
		$view->setConfig(clone $this->instance->getConfig());

		$this->assertTrue($view->getPackage() instanceof NullPackage);
		$this->assertEquals('stub', $view->getName());
		$this->assertEquals('integrate', $view->getPackage()->getName());

		$config = $view->getConfig();

		$this->assertEquals('stub', $config['name']);
		$this->assertEquals('integrate', $config['package.name']);
		// $this->assertEquals($this->getPackagePath($this->instance->getPackage()), Path::clean($config['package.path']));

		$paths = $view->getRegisteredPaths();

		$paths = array_values(iterator_to_array(clone $paths));

		$this->assertPathEquals($this->getPath($this->instance->getPackage()) . '/Templates/stub', $paths[0]);
		$this->assertPathEquals(Ioc::getConfig()->get('path.templates') . '/integrate/stub', $paths[1]);
		$this->assertPathEquals(realpath(__DIR__ . '/../../src') . '/Core/Resources/Templates', $paths[2]);
		$this->assertPathEquals(Ioc::getConfig()->get('path.templates'), $paths[3]);

		$this->assertEquals('<h1>Flower</h1>', trim($view->setLayout('flower')->render()));
		$this->assertEquals('<h1>Test</h1>', trim($view->setLayout('test.test')->render()));
		$this->assertEquals('<h1>Test</h1>', trim($view->setLayout('_global.test')->render()));
	}

	/**
	 * testNewDefaultView
	 *
	 * @return  void
	 */
	public function testNewDefaultView()
	{
		$view = new HtmlView;
		$view->setConfig(clone $this->instance->getConfig());

		$this->assertTrue($view->getPackage() instanceof NullPackage);
		$this->assertEquals('stub', $view->getName());
		$this->assertEquals('integrate', $view->getPackage()->getName());

		$config = $view->getConfig();

		$this->assertEquals('stub', $config['name']);
		$this->assertEquals('integrate', $config['package.name']);
		// $this->assertEquals($this->getPackagePath($this->instance->getPackage()), Path::clean($config['package.path']));

		TestHelper::invoke($view, 'registerPaths');

		$paths = $view->getRenderer()->getPaths();
		$paths = array_values(iterator_to_array(clone $paths));

		$this->assertPathEquals($this->getPath($this->instance->getPackage()) . '/Templates/stub', $paths[0]);
		$this->assertPathEquals(Ioc::getConfig()->get('path.templates') . '/integrate/stub', $paths[1]);
		$this->assertPathEquals(realpath(__DIR__ . '/../../src') . '/Core/Resources/Templates', $paths[2]);
		$this->assertPathEquals(Ioc::getConfig()->get('path.templates'), $paths[3]);

		$this->assertEquals('<h1>Flower</h1>', trim($view->setLayout('flower')->render()));
		$this->assertEquals('<h1>Test</h1>', trim($view->setLayout('test.test')->render()));
		$this->assertEquals('<h1>Test</h1>', trim($view->setLayout('_global.test')->render()));
	}
}