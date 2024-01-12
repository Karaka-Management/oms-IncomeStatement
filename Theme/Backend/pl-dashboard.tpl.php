<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\IncomeStatement
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

echo $this->data['nav']->render();
?>
<div class="row" style="font-size: 0.8rem;">
    <div class="col-xs-12">
        <div style="background: #ff00ff99;">
            <div style="display: flex; flex-direction: row; align-items: center;">
                <div style="flex: 1; text-align: center;"></div>
                <div style="box-sizing: border-box; width: 150px; text-align: center;">Category</div>
                <div style="flex: 1; text-align: center;">1</div>
                <div style="flex: 1; text-align: center;">2</div>
                <div style="flex: 1; text-align: center;">3</div>
                <div style="flex: 1; text-align: center;">4</div>
                <div style="flex: 1; text-align: center;">5</div>
                <div style="flex: 1; text-align: center;">6</div>
                <div style="flex: 1; text-align: center;">7</div>
                <div style="flex: 1; text-align: center;">8</div>
                <div style="flex: 1; text-align: center;">9</div>
                <div style="flex: 1; text-align: center;">10</div>
                <div style="flex: 1; text-align: center;">11</div>
                <div style="flex: 1; text-align: center;">12</div>
                <div style="flex: 1; text-align: center;">1</div>
                <div style="flex: 1; text-align: center;">2</div>
                <div style="flex: 1; text-align: center;">3</div>
                <div style="flex: 1; text-align: center;">4</div>
                <div style="flex: 1; text-align: center;">5</div>
                <div style="flex: 1; text-align: center;">6</div>
                <div style="flex: 1; text-align: center;">7</div>
                <div style="flex: 1; text-align: center;">8</div>
                <div style="flex: 1; text-align: center;">9</div>
                <div style="flex: 1; text-align: center;">10</div>
                <div style="flex: 1; text-align: center;">11</div>
                <div style="flex: 1; text-align: center;">12</div>
                <div style="flex: 1; text-align: center;">12</div>
                <div style="flex: 1; text-align: center;">12</div>
                <div style="flex: 1; text-align: center;">Diff %</div>
                <div style="flex: 1; text-align: center;">Diff USD</div>
            </div>
        </div>
    </div>
</div>

<?php
foreach ($this->data['elements'] as $element) :
    if ($element->parent !== null) {
        continue;
    }
?>
<div class="row" style="font-size: 0.8rem;">
    <div class="col-xs-12">
        <div style="display: flex; flex-direction: row; align-items: center; background: #ff000099;">
            <div style="flex: 1; padding: 1px;"><label for="iSegment1-expand" class="btn"><i class="g-icon">add_circle</i></label></div>
            <div style="box-sizing: border-box; width: 120px; padding-left: 0px;"><?= $this->printHtml($element->getL11n()); ?></div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
            <div style="flex: 1; padding: 1px;">+0.00%</div>
        </div>

        <!-- Input here -->
        <!-- Child here -->
    </div>
</div>
<?php endforeach; ?>
