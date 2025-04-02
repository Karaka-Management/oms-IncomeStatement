<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\IncomeStatement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\IncomeStatement\Models;

/**
 * IncomeStatement class.
 *
 * @package Modules\IncomeStatement\Models
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 */
class IncomeStatement
{
    /**
     * Account ID.
     *
     * @var int
     * @since 1.0.0
     */
    public int $id = 0;

    public string $code = '';

    public string $name = '';

    public ?int $unit = null;

    public bool $isDefault = false;

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
