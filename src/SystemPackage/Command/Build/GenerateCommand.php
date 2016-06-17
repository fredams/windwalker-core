<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2014 - 2015 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Windwalker\SystemPackage\Command\Build;

use Windwalker\Console\Command\Command;
use Windwalker\Core\Ioc;
use Windwalker\Filesystem\File;

/**
 * Class GenerateCommand
 */
class GenerateCommand extends Command
{
	/**
	 * An enabled flag.
	 *
	 * @var bool
	 */
	public static $isEnabled = true;

	/**
	 * Console(Argument) name.
	 *
	 * @var  string
	 */
	protected $name = 'gen-command';

	/**
	 * The command description.
	 *
	 * @var  string
	 */
	protected $description = 'Generate a command class.';

	/**
	 * The usage to tell user how to use this command.
	 *
	 * @var string
	 */
	protected $usage = 'gen-command <command name> <namespace> [-d=description]';

	/**
	 * Template to generate command.
	 *
	 * @var string
	 */
	protected $template = <<<TMPL
<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2014 - 2015 LYRASOFT. All rights reserved.
 * @license    GNU Lesser General Public License version 3 or later.
 */

namespace {{NAMESPACE}};

use Windwalker\Console\Command\Command;

/**
 * Class {{CLASS}}
 */
class {{CLASS}}Command extends Command
{
	/**
	 * An enabled flag.
	 *
	 * @var bool
	 */
	public static \$isEnabled = true;

	/**
	 * Console(Argument) name.
	 *
	 * @var  string
	 */
	protected \$name = '{{NAME}}';

	/**
	 * The command description.
	 *
	 * @var  string
	 */
	protected \$description = '{{DESCRIPTION}}';

	/**
	 * The usage to tell user how to use this command.
	 *
	 * @var string
	 */
	protected \$usage = '{{NAME}} <cmd><command></cmd> <option>[option]</option>';

	/**
	 * Initialise command information.
	 *
	 * @return void
	 */
	public function init()
	{
		// \$this->addArgument();

		parent::init();
	}

	/**
	 * Execute this command.
	 *
	 * @return int|void
	 */
	protected function doExecute()
	{
		return parent::doExecute();
	}
}

TMPL;

	/**
	 * Configure command information.
	 *
	 * @return void
	 */
	public function init()
	{
		$this->addOption(
			array('d', 'description'),
			null,
			'Command description'
		);

		parent::init();
	}

	/**
	 * Execute this command.
	 *
	 * @return int|void
	 */
	protected function doExecute()
	{
		@$name       = $this->io->getArgument(0) ? : exit("Please enter command name");
		@$namespace  = $this->io->getArgument(1) ? : exit("Please enter command namespace");
		$description = $this->getOption('d') ? : $name;

		if (!$name || !$namespace)
		{
			$this->out('Need name & namespace.');

			return;
		}

		// Regularize Namespace
		$namespace = str_replace(array('/', '\\'), ' ', $namespace);

		$namespace = ucwords($namespace);

		$namespace = str_replace(' ', '\\', $namespace);

		$namespace = explode('\\', $namespace);

		if ($namespace[0] == 'Command')
		{
			array_shift($namespace);
		}

		$class = $namespace;

		$class = array_pop($class);

		$namespace = implode('\\', $namespace);

		$replace = array(
			'{{NAME}}'      => $name,
			'{{NAMESPACE}}' => $namespace,
			'{{CLASS}}'     => $class,
			'{{DESCRIPTION}}' => $description
		);

		$content = strtr($this->template, $replace);

		$config = Ioc::getConfig();

		$file = $config->get('path.root') . '/src/' . $namespace . '/' . $class . 'Command.php';

		$file = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $file);

		if (!File::write($file, $content))
		{
			$this->out()->out('Failure when writing file.');

			return false;
		}

		$this->out('File generated: ' . $file);

		return true;
	}
}
