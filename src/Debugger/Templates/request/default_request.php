<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2014 - 2015 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

use Windwalker\Debugger\Html\BootstrapKeyValueGrid;

?>
    <h2><?php echo strtoupper($type) ?> Variables</h2>

<?php if (!empty($collector['request'][$type])) : ?>
    <?php
    $gridObject = BootstrapKeyValueGrid::create()->addHeader();

    foreach ($collector['request'][$type] as $key => $value) {
        if (is_array($value) || is_object($value)) {
            $value = \Windwalker\h('pre', [], print_r($value, 1));
        }

        $gridObject->addItem($key, $value);
    }

    echo $gridObject;
    ?>
    <br/><br/>
<?php else : ?>
    No data.
    <br/><br/>
<?php endif; ?>
