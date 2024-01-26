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
final class IncomeStatementElementMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'incomestmt_pl_element_id'     => ['name' => 'incomestmt_pl_element_id',          'type' => 'int',    'internal' => 'id'],
        'incomestmt_pl_element_code'   => ['name' => 'incomestmt_pl_element_code',        'type' => 'string', 'internal' => 'code', 'autocomplete' => true],
        'incomestmt_pl_element_order'  => ['name' => 'incomestmt_pl_element_order',        'type' => 'int', 'internal' => 'order'],
        'incomestmt_pl_element_parent' => ['name' => 'incomestmt_pl_element_parent',        'type' => 'int', 'internal' => 'parent'],
        'incomestmt_pl_element_pl'     => ['name' => 'incomestmt_pl_element_pl',        'type' => 'int', 'internal' => 'incomeStatement'],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:class-string, table:string, self?:?string, external?:?string, column?:string}>
     * @since 1.0.0
     */
    public const HAS_MANY = [
        'l11n' => [
            'mapper'   => IncomeStatementElementL11nMapper::class,
            'table'    => 'incomestmt_pl_element_l11n',
            'self'     => 'incomestmt_pl_element_l11n_element',
            'column'   => 'content',
            'external' => null,
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'incomestmt_pl_element';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'incomestmt_pl_element_id';
}
