<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2014 - 2015 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

use Windwalker\Debugger\Html\BootstrapKeyValueGrid;
use Windwalker\Dom\HtmlElement;

?>
    <h2><?php echo strtoupper($type) ?> Variables</h2>

<?php if (!empty($collector['request'][$type])) : ?>
    <?php
    $gridObject = BootstrapKeyValueGrid::create()->addHeader();

    foreach ($collector['request'][$type] as $bagName => $bagValue) {
        if (is_array($bagValue) || is_object($bagValue)) {
            $gridObject->addTitle(new HtmlElement('strong', $bagName));

            if ($bagValue) {
                foreach ($bagValue as $key => $value) {
                    if (is_array($value) || is_object($value)) {
                        $value = new HtmlElement('pre', print_r($value, 1));
                    }

                    $gridObject->addItem($key, $value);
                }
            } else {
                $gridObject->addRow()
                    ->setRowCell('key', 'No Data', ['colspan' => 3]);
            }
        } else {
            $gridObject->addItem($bagName, $bagValue);
        }
    }

    echo $gridObject;
    ?>
    <br/><br/>
<?php else : ?>
    No data.
    <br/><br/>
<?php endif; ?>
