<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\IncomeStatement\tests\Admin;

/**
 * @internal
 */
final class AdminTest extends \PHPUnit\Framework\TestCase
{
    protected const NAME = 'IncomeStatement';

    protected const URI_LOAD = 'http://127.0.0.1/en/backend/controlling/pl';

    use \tests\Modules\ModuleTestTrait;
}
