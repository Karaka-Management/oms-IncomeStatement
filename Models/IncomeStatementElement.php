<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\IncomeStatement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\IncomeStatement\Models;

use phpOMS\Localization\BaseStringL11n;
use phpOMS\Localization\ISO639x1Enum;

/**
 * IncomeStatement class.
 *
 * @package Modules\IncomeStatement\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class IncomeStatementElement
{
    /**
     * Account ID.
     *
     * @var int
     * @since 1.0.0
     */
    public int $id = 0;

    public string $code = '';

    public int $type = 0;

    public string $formula = '';

    public string $style = '';

    public int $order = 0;

    public bool $expanded = false;

    public int $incomeStatement = 0;

    public ?int $parent = null;

    public array $accounts = [];

    /*
     * String l11n
     *
     * @var string | BaseStringL11n
     * @since 1.0.0
     */
    public string | BaseStringL11n $l11n = '';

    /**
     * Set l11n
     *
     * @param string|BaseStringL11n $l11n Tag article l11n
     * @param string                $lang Language
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setL11n(string | BaseStringL11n $l11n, string $lang = ISO639x1Enum::_EN) : void
    {
        if ($l11n instanceof BaseStringL11n) {
            $this->l11n = $l11n;
        } elseif (isset($this->l11n) && $this->l11n instanceof BaseStringL11n) {
            $this->l11n->content  = $l11n;
            $this->l11n->language = $lang;
        } else {
            $this->l11n           = new BaseStringL11n();
            $this->l11n->content  = $l11n;
            $this->l11n->language = $lang;
        }
    }

    /**
     * @return string
     *
     * @since 1.0.0
     */
    public function getL11n() : string
    {
        if (!isset($this->l11n)) {
            return '';
        }

        return $this->l11n instanceof BaseStringL11n ? $this->l11n->content : $this->l11n;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return [
            'id' => $this->id,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : mixed
    {
        return $this->toArray();
    }
}
