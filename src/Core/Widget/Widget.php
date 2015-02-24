<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Windwalker\Core\Widget;

use Windwalker\Core\Package\PackageHelper;
use Windwalker\Core\Renderer\RendererHelper;
use Windwalker\Core\Utilities\Iterator\PriorityQueue;
use Windwalker\Data\Data;
use Windwalker\Renderer\PhpRenderer;
use Windwalker\Renderer\RendererInterface;
use Windwalker\Utilities\Queue\Priority;

/**
 * The Widget class.
 * 
 * @since  2.0
 */
class Widget implements WidgetInterface
{
	/**
	 * Property renderer.
	 *
	 * @var  RendererInterface
	 */
	protected $renderer;

	/**
	 * Property layout.
	 *
	 * @var string
	 */
	protected $layout;

	/**
	 * Property pathRegistered.
	 *
	 * @var  bool
	 */
	protected $pathRegistered = false;

	/**
	 * Property debug.
	 *
	 * @var bool
	 */
	protected $debug = false;

	/**
	 * Property package.
	 *
	 * @var  string
	 */
	private $package;

	/**
	 * Class init.
	 *
	 * @param string            $layout
	 * @param RendererInterface $renderer
	 * @param string            $package
	 */
	public function __construct($layout, RendererInterface $renderer = null, $package = null)
	{
		$this->layout   = $layout;
		$this->package  = $package;
		$this->renderer = $renderer ? : new PhpRenderer;

		// Create PriorityQueue
		$this->createPriorityQueue();

		$this->initialise();
	}

	/**
	 * initialise
	 *
	 * @return  void
	 */
	protected function initialise()
	{
	}

	/**
	 * render
	 *
	 * @param array $data
	 *
	 * @return string
	 */
	public function render($data = array())
	{
		$this->registerPaths();

		$data = new Data($data);

		$data->layout = $this->layout;
		$data->renderer = get_class($this->renderer);

		if ($this->isDebug())
		{
			$data->paths = iterator_to_array(clone $this->getPaths());
		}

		return $this->renderer->render($this->layout, $data);
	}

	/**
	 * Method to get property Layout
	 *
	 * @return  string
	 */
	public function getLayout()
	{
		return $this->layout;
	}

	/**
	 * Method to set property layout
	 *
	 * @param   string $layout
	 *
	 * @return  static  Return self to support chaining.
	 */
	public function setLayout($layout)
	{
		$this->layout = $layout;

		return $this;
	}

	/**
	 * Method to get property Renderer
	 *
	 * @return  RendererInterface
	 */
	public function getRenderer()
	{
		return $this->renderer;
	}

	/**
	 * Method to set property renderer
	 *
	 * @param   RendererInterface $renderer
	 *
	 * @return  static  Return self to support chaining.
	 */
	public function setRenderer(RendererInterface $renderer)
	{
		$this->renderer = $renderer;

		return $this;
	}

	/**
	 * registerPaths
	 *
	 * @return  static
	 */
	protected function registerPaths()
	{
		if (!$this->pathRegistered)
		{
			$paths = RendererHelper::getGlobalPaths()->merge($this->renderer->getPaths());

			$this->renderer->setPaths($paths);

			// Set package path
			if ($this->package)
			{
				$package = PackageHelper::getPackage($this->package);

				$this->renderer->addPath($package->getDir() . '/Templates', Priority::BELOW_NORMAL);
			}

			$this->pathRegistered = true;
		}

		return $this;
	}

	/**
	 * addPath
	 *
	 * @param string  $path
	 * @param integer $priority
	 *
	 * @return  static
	 */
	public function addPath($path, $priority = Priority::NORMAL)
	{
		$this->renderer->addPath($path, $priority);

		return $this;
	}

	/**
	 * getPaths
	 *
	 * @return  PriorityQueue
	 */
	public function getPaths()
	{
		return $this->renderer->getPaths();
	}

	/**
	 * setPaths
	 *
	 * @param array|\SplPriorityQueue $paths
	 *
	 * @return  static
	 */
	public function setPaths($paths)
	{
		$this->renderer->setPaths($paths);

		$this->createPriorityQueue();

		return $this;
	}

	/**
	 * Method to get property Debug
	 *
	 * @return  boolean
	 */
	public function isDebug()
	{
		return $this->debug;
	}

	/**
	 * Method to set property debug
	 *
	 * @param   boolean $debug
	 *
	 * @return  static  Return self to support chaining.
	 */
	public function setDebug($debug)
	{
		$this->debug = $debug;

		return $this;
	}

	/**
	 * createPriorityQueue
	 *
	 * @return  static
	 */
	protected function createPriorityQueue()
	{
		$paths = $this->renderer->getPaths();

		if (!($paths instanceof PriorityQueue))
		{
			$paths = new PriorityQueue($paths);

			$this->renderer->setPaths($paths);
		}

		return $this;
	}

	/**
	 * Method to get property Package
	 *
	 * @return  string
	 */
	public function getPackage()
	{
		return $this->package;
	}

	/**
	 * Method to set property package
	 *
	 * @param   string $package
	 *
	 * @return  static  Return self to support chaining.
	 */
	public function setPackage($package)
	{
		$this->package = $package;

		return $this;
	}

	/**
	 * reset
	 *
	 * @return  static
	 */
	public function reset()
	{
		$this->pathRegistered = false;

		if ($this->renderer instanceof PhpRenderer)
		{
			$this->renderer->reset();
		}

		$this->renderer->setPaths(array());

		return $this;
	}
}
