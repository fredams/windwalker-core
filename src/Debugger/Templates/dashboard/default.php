<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2014 - 2015 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

$this->extend('_global.fluid-layout');
?>

<?php $this->block('page_title') ?>Dashboard<?php $this->endblock(); ?>

<?php $this->block('content') ?>
<div class="container-fluid">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>See</th>
                <th>IP</th>
                <th>Method</th>
                <th>URL</th>
                <th>Time</th>
                <th>Info</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item) : ?>
                <tr>
                    <td>
                        <a class="text-muted" href="<?php echo $item->link ?>">
                            <?php echo $item->id; ?>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-info btn-sm" href="<?php echo $item->link ?>">
                            <small class="fa fa-eye"></small>
                        </a>
                    </td>
                    <td>
                        <?php echo $item->ip; ?>
                    </td>
                    <td>
                        <?php echo $item->method; ?>
                    </td>
                    <td>
                        <a class="text-muted" href="<?php echo $item->url; ?>" target="_blank">
                            <?php echo $item->url; ?>
                            <small class="fa fa-external-link-alt"></small>
                        </a>
                    </td>
                    <td>
                        <?php echo $item->time; ?>
                    </td>
                    <td class="text-nowrap">
                <span class="<?php echo $item->status_style ?>" aria-label="Http Status: <?php echo $item->status ?>"
                    data-microtip-position="top" role="tooltip">
                    <?php echo $item->status; ?>
                </span>
                        &nbsp;
                        <?php if ($item->exception->notNull()) : ?>
                            <span class="badge badge-danger" aria-label="<?php echo $item->exception->type ?>"
                                data-microtip-position="top" role="tooltip">E</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $this->endblock(); ?>
