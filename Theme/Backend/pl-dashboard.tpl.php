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

use phpOMS\Localization\ISO639Enum;

function render_accounts(array $accounts) : string
{
    $row = '';

    foreach ($accounts as $account) {
        $row .= <<<ROW
        <div class="account data-row">
            <div class="expand-col"></div>
            <div class="name-col">{$account->code} - {$account->getL11n()}</div>
            <div>123,456.00</div>
            <div>123,456.00</div>
            <div>123,456.00</div>
            <div>123,456.00</div>
            <div>123,456.00</div>
            <div>123,456.00</div>
            <div>123,456.00</div>
            <div>123,456.00</div>
            <div>123,456.00</div>
            <div>123,456.00</div>
            <div>123,456.00</div>
            <div>123,456.00</div>
            <div class="total-col">123,456.00</div>
            <div class="total-col">1,234.56 %</div>
            <div class="total-col">123,456.00</div>
        </div>
        ROW;
    }

    return $row;
}

function render_elements(array $elements, ?int $parent = null) : string
{
    $row = '';
    $fn  = 'render_elements';
    $acc  = 'render_accounts';

    foreach ($elements as $element) {
        if ($element->parent !== $parent) {
            continue;
        }

        $expand = '';
        foreach ($elements as $child) {
            if ($child->parent === $element->id
                || !empty($element->accounts)
            ) {
                $expand = '<label for="iEle' . $element->id . '-expand" class="btn maximize"><i class="g-icon">add_circle</i></label><label for="iEle' . $element->id . '-expand" class="btn minimize"><i class="g-icon">do_not_disturb_on</i></label>';
                break;
            }
        }

        $expanded = $element->expanded ? ' checked' : '';

        $row .= <<<ROW
        <div>
            <input id="iEle{$element->id}-expand" type="checkbox" class="vh"{$expanded}>
            <div class="{$element->style} data-row">
                <div class="expand-col">{$expand}</div>
                <div class="name-col">{$element->getL11n()}</div>
                <div>123,456.00</div>
                <div>123,456.00</div>
                <div>123,456.00</div>
                <div>123,456.00</div>
                <div>123,456.00</div>
                <div>123,456.00</div>
                <div>123,456.00</div>
                <div>123,456.00</div>
                <div>123,456.00</div>
                <div>123,456.00</div>
                <div>123,456.00</div>
                <div>123,456.00</div>
                <div class="total-col">123,456.00</div>
                <div class="total-col">1,234.56 %</div>
                <div class="total-col">123,456.00</div>
            </div>

            <div class="checked-visibility">
                {$fn($elements, $element->id)}
                {$acc($element->accounts)}
            </div>
        </div>
        ROW;
    }

    return $row;
}

echo $this->data['nav']->render();
?>
<style>
    div {
        box-sizing: border-box;
    }

    input:checked+div > div > .maximize {
        display: none;
    }

    input+div > div > .minimize {
        display: none;
    }

    input:checked+div > div > .minimize {
        display: inline-block;
    }

    .title-cell {
        padding: 1px;
        text-align: center;
        width: 95px;
    }

    .category {
        background: #fff;
        border-bottom: 1px solid #000 !important;
    }

    .subtotal {
        background: #ffa82e;
        border-bottom: 1px solid #000 !important;
    }

    .subtotal .total-col {
        background: #ffa82e;
    }

    .total {
        background: #ffa82e;
        border-bottom: 1px solid #000 !important;
    }

    .total .total-col {
        background: #ffa82e;
    }

    .total-col {
        background: #cbfbcb;
    }

    .data-row {
        display: inline-flex;
        flex-direction: row;
        border-bottom: 1px solid #fff;
        align-items: stretch;
        min-height: 34px;
    }

    .data-row div {
        padding: .2rem 3px .2rem 3px;
        display: flex;
        align-items: center;
    }

    .account:nth-child(2n) {
        background: #f9f9f9;
    }

    .account:nth-child(2n + 1) {
        background: #efefef;
    }

    .data-row div:nth-child(n+3) {
        width: 95px;
        justify-content: end;
    }

    .expand-col {
        width: 30px;
        min-width: 30px;
        padding: 1px;
    }

    .name-col {
        width: 150px;
        min-width: 150px;
        padding-left: 0px;
        border-right: 1px solid #000;
        overflow: clip;
    }
</style>

<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="box">
            <div class="form-group">
                <div class="input-control">
                    <select id="iStructure" name="structure" data-action='[{"listener": "change", "action": [{"key": 1, "type": "redirect", "uri": "{%}&structure={#iStructure}", "target": "self"}]}]'>
                        <?php foreach ($this->data['structures'] as $structure) : ?>
                            <option value="<?= $structure->id; ?>"<?= $this->request->getDataInt('structure') === $structure->id ? ' selected' : ''; ?>><?= $this->printHtml($structure->name); ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="input-control">
                    <select id="iLanguage" name="language" data-action='[{"listener": "change", "action": [{"key": 1, "type": "redirect", "uri": "{%}&language={#iLanguage}", "target": "self"}]}]'>
                        <?php foreach ($this->data['languages'] as $language) : ?>
                            <option value="<?= $language; ?>"<?= $this->request->getDataString('language') === $language ? ' selected' : ''; ?>><?= $this->printHtml(ISO639Enum::getBy2Code($language)); ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-6">
        <section class="portlet">
            <div class="portlet-body">
                <div class="form-group">
                    <div class="input-control">
                        <label><?= $this->getHtml('Start'); ?></label>
                        <input type="date">
                    </div>
                    <div class="input-control">
                        <label><?= $this->getHtml('Start'); ?></label>
                        <input type="date">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-control">
                        <label><?= $this->getHtml('Interval'); ?></label>
                        <select>
                            <option><?= $this->getHtml('Monthly'); ?>
                            <option><?= $this->getHtml('Quarterly'); ?>
                            <option><?= $this->getHtml('Annually'); ?>
                        </select>
                    </div>
                    <div class="input-control">
                        <label><?= $this->getHtml('Environment'); ?></label>
                        <select></select>
                    </div>
                </div>
            </div>
            <div class="portlet-foot">
                <input type="submit" value="<?= $this->getHtml('Submit', '0', '0'); ?>">
                <input class="close" type="submit" value="<?= $this->getHtml('Reset', '0', '0'); ?>">
            </div>
        </section>
    </div>

    <div class="col-xs-12 col-md-6">
        <section class="portlet">
            <div class="portlet-body">
                <div class="form-group">
                    <div class="input-control">
                        <label><?= $this->getHtml('Start'); ?></label>
                        <input type="date">
                    </div>
                    <div class="input-control">
                        <label><?= $this->getHtml('Start'); ?></label>
                        <input type="date">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-control">
                        <label><?= $this->getHtml('Interval'); ?></label>
                        <select>
                            <option><?= $this->getHtml('Monthly'); ?>
                            <option><?= $this->getHtml('Quarterly'); ?>
                            <option><?= $this->getHtml('Annually'); ?>
                        </select>
                    </div>
                    <div class="input-control">
                        <label><?= $this->getHtml('Environment'); ?></label>
                        <select></select>
                    </div>
                </div>
            </div>
            <div class="portlet-foot">
                <input type="submit" value="<?= $this->getHtml('Submit', '0', '0'); ?>">
                <input class="close" type="submit" value="<?= $this->getHtml('Reset', '0', '0'); ?>">
            </div>
        </section>
    </div>
</div>

<div class="tabview tab-2">
    <div class="box">
        <ul class="tab-links">
            <li><label for="c-tab-1"><?= $this->getHtml('Overview'); ?></label>
            <li><label for="c-tab-4"><?= $this->getHtml('Charts'); ?></label>
        </ul>
    </div>
    <div class="tab-content">
    <input type="radio" id="c-tab-1" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-1' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row sticky" style="font-size: 0.8rem; display: flex;">
                <div style="display: flex; flex-direction: row; align-items: center; color: #fff; background: #3697db; padding: .5rem 0 .5rem 0">
                    <div style="width: 30px; min-width: 30px; text-align: center;"></div>
                    <div style="width: 150px; min-width: 150px; box-sizing: border-box; text-align: center;"><?= $this->getHtml('Category'); ?></div>
                    <div class="title-cell">1</div>
                    <div class="title-cell">2</div>
                    <div class="title-cell">3</div>
                    <div class="title-cell">4</div>
                    <div class="title-cell">5</div>
                    <div class="title-cell">6</div>
                    <div class="title-cell">7</div>
                    <div class="title-cell">8</div>
                    <div class="title-cell">9</div>
                    <div class="title-cell">10</div>
                    <div class="title-cell">11</div>
                    <div class="title-cell">12</div>
                    <div class="title-cell"><?= $this->getHtml('Total'); ?></div>
                    <div class="title-cell"><?= $this->getHtml('Diff%'); ?></div>
                    <div class="title-cell"><?= $this->getHtml('Diff'); ?> USD</div>
                </div>
            </div>

            <div class="row" style="font-size: 0.8rem;">
                <div class="col-xs-12"><?= \render_elements($this->data['elements'], null); ?></div>
            </div>
        </div>

        <input type="radio" id="c-tab-4" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-4' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
                <div class="col-xs-12">
                    <section class="portlet">
                        <div class="portlet-body">
                            <img height="100%" width="100%" src="Web/Backend/img/under_construction.svg">
                            <!--
                                PL
                                1. Ebit
                                2. Ebit margin
                                3. EBITDA
                                4. EBITDA margin
                                5. Gross profit
                                6. Gross profit margin
                                7. HR development (headcount, costs, costs per employee, total+per department)
                                8. HR expense ratio
                                9. HR count
                                10. HR expense per employee
                                11. Total HR expenses (headcount, costs, costs per employee, total+per department)
                                12. Total HR expense ratio
                                13. Total HR expense per employee
                                14. Sales
                                15. HR sales per employee
                                16. Depreciation ratio
                                17. Sales segmentation
                                18. Net profit margin

                                Balance
                                1. Current Ratio
                                2. Quick Ratio
                                3. Working Capital
                                4. Debt/Equity
                                5. DSO
                                6. DPO
                                7. DIO
                                8. Cash conversion cycle
                                9. Receivables Turnover
                                10. Inventory Turnover
                                11. Average age of inventory
                                12. Intangibles to book value
                                13. Inventory to sales
                                14. LT dept as % of invested capital
                                15. ST dept as % of invested capital
                                16. LT dept to total debt
                                17. ST debt to total debt
                                18. Total liabilities to total assets
                                19. Price to working capital
                                20. Cash Ratio
                                21. Payable Turnover
                                22. Return on assets
                                23. Asset turnover ratio

                            -->
                        </div>
                    </section>
                </div>
            </div>
        </div>

    </div>
</div>