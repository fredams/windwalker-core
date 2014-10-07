<?php
/**
 * Part of auth project. 
 *
 * @copyright  Copyright (C) 2011 - 2014 SMS Taiwan, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Windwalker\Core\View;

use Windwalker\Core\Ioc;
use Windwalker\Core\Renderer\RendererHelper;
use Windwalker\Utilities\Queue\Priority;
use Windwalker\Data\Data;
use Windwalker\Renderer\RendererInterface;
use Windwalker\Core\View\Helper\ViewHelper;
use Windwalker\Utilities\Reflection\ReflectionHelper;

/**
 * Class HtmlView
 *
 * @since 1.0
 */
class HtmlView extends \Windwalker\View\HtmlView
{
	/**
	 * Property name.
	 *
	 * @var  string
	 */
	protected $name = null;

	/**
	 * Property package.
	 *
	 * @var  string
	 */
	protected $package;

	/**
	 * Method to instantiate the view.
	 *
	 * @param   array             $data     The data array.
	 * @param   RendererInterface $renderer The renderer engine.
	 */
	public function __construct($data = array(), RendererInterface $renderer = null)
	{
		parent::__construct($data, $renderer);

		$this->registerPaths();

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
	 * prepareData
	 *
	 * @param \Windwalker\Data\Data $data
	 *
	 * @return  void
	 */
	protected function prepareData($data)
	{
	}

	/**
	 * getData
	 *
	 * @return  \Windwalker\Data\Data
	 */
	public function getData()
	{
		if (!$this->data)
		{
			$this->data = new Data;
		}

		return $this->data;
	}

	/**
	 * setData
	 *
	 * @param   \Windwalker\Data\Data $data
	 *
	 * @return  static  Return self to support chaining.
	 */
	public function setData($data)
	{
		$this->data = $data;

		return $this;
	}

	/**
	 * render
	 *
	 * @return  string
	 *
	 * @throws \RuntimeException
	 */
	public function render()
	{
		$this->getName();

		$data = $this->getData();

		$this->prepareData($data);

		$this->prepareGlobals($data);

		return $this->renderer->render($this->getLayout(), (array) $data);
	}

	/**
	 * registerPaths
	 *
	 * @return  void
	 */
	protected function registerPaths()
	{
		$paths = $this->renderer->getPaths();

		$viewTmpl = dirname(ReflectionHelper::getPath($this)) . '/../../Templates/' . $this->getName();

		if (is_dir($viewTmpl))
		{
			$paths->insert(realpath($viewTmpl), Priority::NORMAL);
		}

		$paths = Priority::createQueue(
			array_merge(iterator_to_array($paths), iterator_to_array(RendererHelper::getGlobalPaths())),
			Priority::LOW
		);

		$this->renderer->setPaths($paths);
	}

	/**
	 * getName
	 *
	 * @return  string
	 */
	public function getName()
	{
		if (!$this->name)
		{
			$class = get_called_class();

			// If we are using this class as default view, return default name.
			if ($class == __CLASS__)
			{
				return $this->name = 'default';
			}

			$class = explode('\\', $class);

			array_pop($class);

			$name = array_pop($class);

			array_pop($class);

			$this->package = strtolower(array_pop($class));

			$this->name = strtolower($name);
		}

		return $this->name;
	}
	
	/**
	 * Method to set property name
	 *
	 * @param   string $name
	 *
	 * @return  static  Return self to support chaining.
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Method to get property Package
	 *
	 * @return  string
	 */
	public function getPackage()
	{
		// Init name & package
		$this->getName();

		return $this->package;
	}

	/**
	 * prepareGlobals
	 *
	 * @param \Windwalker\Data\Data $data
	 *
	 * @return  void
	 */
	protected function prepareGlobals($data)
	{
		$data->view = new Data;

		$data->view->name = $this->getName();
		$data->view->layout = $this->getLayout();

		$data->bind(ViewHelper::getGlobalVariables());
	}
}
 
