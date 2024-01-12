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
 * IncomeStatementElement mapper class.
 *
 * @package Modules\IncomeStatement\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of BaseStringL11n
 * @extends DataMapperFactory<T>
 */
final class IncomeStatementElementL11nMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'incomestmt_pl_element_l11n_id'          => ['name' => 'incomestmt_pl_element_l11n_id',          'type' => 'int',    'internal' => 'id'],
        'incomestmt_pl_element_l11n_title'        => ['name' => 'incomestmt_pl_element_l11n_title',        'type' => 'string', 'internal' => 'content', 'autocomplete' => true],
        'incomestmt_pl_element_l11n_element'  => ['name' => 'incomestmt_pl_element_l11n_element',  'type' => 'int',    'internal' => 'ref'],
        'incomestmt_pl_element_l11n_lang'    => ['name' => 'incomestmt_pl_element_l11n_lang',    'type' => 'string', 'internal' => 'language'],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'incomestmt_pl_element_l11n';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'incomestmt_pl_element_l11n_id';

    /**
     * Model to use by the mapper.
     *
     * @var class-string<T>
     * @since 1.0.0
     */
    public const MODEL = BaseStringL11n::class;
}
