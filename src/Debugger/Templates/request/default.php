<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2014 - 2015 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

use Windwalker\Html\Grid\KeyValueGrid;
use Windwalker\Profiler\Point\Collector;

$this->extend('_global.html');

/**
 * @var  Collector  $collector
 */
?>

<?php $this->block('page_title') ?>Request<?php $this->endblock(); ?>

<?php $this->block('content') ?>

	<?php echo $this->load('default_request', array('type' => 'get')) ?>
	<?php echo $this->load('default_request', array('type' => 'post')) ?>
	<?php echo $this->load('default_request', array('type' => 'files')) ?>
	<?php echo $this->load('session_request', array('type' => 'session')) ?>
	<?php echo $this->load('default_request', array('type' => 'cookie')) ?>
	<?php echo $this->load('default_request', array('type' => 'server')) ?>
	<?php echo $this->load('default_request', array('type' => 'env')) ?>

<?php $this->endblock() ?>