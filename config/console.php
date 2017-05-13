<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

use Windwalker\Utilities\ArrayHelper;

return ArrayHelper::merge(
	include __DIR__ . '/windwalker.php',
	[
		'packages' => [

		],

		'providers' =>[
			'console'  => \Windwalker\Core\Provider\ConsoleProvider::class,
			'datetime' => \Windwalker\Core\Provider\DateTimeProvider::class,
			'logger'   => \Windwalker\Core\Provider\LoggerProvider::class,
			'event'    => \Windwalker\Core\Provider\EventProvider::class,
			'database' => \Windwalker\Core\Provider\DatabaseProvider::class,
			'lang'     => \Windwalker\Core\Provider\LanguageProvider::class,
			'cache'    => \Windwalker\Core\Provider\CacheProvider::class,
		],

		'console' => [
			'commands' => [
				'asset'     => \Windwalker\Core\Asset\Command\AssetCommand::class,
				'migration' => \Windwalker\Core\Migration\Command\MigrationCommand::class,
				'seed'      => \Windwalker\Core\Seeder\Command\SeedCommand::class,
				'package'   => \Windwalker\Core\Package\Command\PackageCommand::class
			],
		],

		'configs' => [
		],

		'listeners' => [
		]
	]
);