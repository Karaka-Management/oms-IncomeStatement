<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\IncomeStatement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\IncomeStatement\Models;

use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;
use phpOMS\Localization\BaseStringL11n;

/**
 * IncomeStatement mapper class.
 *
 * @package Modules\IncomeStatement\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of BaseStringL11n
 * @extends DataMapperFactory<T>
 */
final class IncomeStatementMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'incomestmt_pl_id'   => ['name' => 'incomestmt_pl_id',          'type' => 'int',    'internal' => 'id'],
        'incomestmt_pl_code' => ['name' => 'incomestmt_pl_code',        'type' => 'string', 'internal' => 'code', 'autocomplete' => true],
        'incomestmt_pl_name' => ['name' => 'incomestmt_pl_name',        'type' => 'string', 'internal' => 'name', 'autocomplete' => true],
        'incomestmt_pl_default' => ['name' => 'incomestmt_pl_default',        'type' => 'bool', 'internal' => 'isDefault'],
        'incomestmt_pl_unit' => ['name' => 'incomestmt_pl_unit',        'type' => 'int', 'internal' => 'unit'],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'incomestmt_pl';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'incomestmt_pl_id';
}
