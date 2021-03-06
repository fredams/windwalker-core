<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2017 LYRASOFT.
 * @license    LGPL-2.0-or-later
 */

namespace Windwalker\Core\Queue\Command\Queue;

use Windwalker\Core\Console\CoreCommand;
use Windwalker\Core\DateTime\Chronos;
use Windwalker\Filesystem\File;

/**
 * The WorkerCommand class.
 *
 * @since  3.2
 */
class RestartCommand extends CoreCommand
{
    /**
     * Property name.
     *
     * @var  string
     */
    protected $name = 'restart';

    /**
     * Property description.
     *
     * @var  string
     */
    protected $description = 'Send restart signal to all workers.';

    /**
     * init
     *
     * @return  void
     */
    protected function init()
    {
        $this->addOption('t')
            ->alias('time')
            ->defaultValue('now')
            ->description('The time to restart all workers.');
    }

    /**
     * doExecute
     *
     * @return  bool
     */
    protected function doExecute()
    {
        $file = $this->console->get('path.temp') . '/queue/restart';

        File::write($file, Chronos::create($this->getOption('time'))->toUnix());

        $this->out('Sent restart signal to all workers.');

        return true;
    }
}
