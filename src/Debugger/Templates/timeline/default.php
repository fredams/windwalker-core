<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2014 - 2015 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

use Windwalker\Profiler\Profiler;

$this->extend('_global.html');

/**
 * @var  Profiler $profiler
 */
?>

<?php $this->block('page_title') ?>Timeline<?php $this->endblock(); ?>

<?php $this->block('content') ?>
    <h2>System Process</h2>

<?php echo $this->load('timeline', ['timeline' => $systemProcess]) ?>

    <br/><br/>

    <h2>All Process</h2>

<?php echo $this->load('timeline', ['timeline' => $allProcess]) ?>
<?php $this->endblock() ?>
