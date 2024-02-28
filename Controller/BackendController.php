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

namespace Modules\IncomeStatement\Controller;

use Modules\IncomeStatement\Models\IncomeStatementElementL11nMapper;
use Modules\IncomeStatement\Models\IncomeStatementElementMapper;
use Modules\IncomeStatement\Models\IncomeStatementMapper;
use phpOMS\Contract\RenderableInterface;
use phpOMS\DataStorage\Database\Query\OrderType;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Views\View;

/**
 * Budgeting controller class.
 *
 * @package Modules\IncomeStatement
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class BackendController extends Controller
{
    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewPLDashboard(RequestAbstract $request, ResponseAbstract $response, $data = null) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/IncomeStatement/Theme/Backend/pl-dashboard');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1006401001, $request, $response);

        $view->data['elements'] = IncomeStatementElementMapper::getAll()
            ->with('l11n')
            ->with('accounts')
            ->with('accounts/l11n')
            ->where('incomeStatement', $request->getDataInt('structure') ?? 1)
            ->where('l11n/language', $request->getDataString('language') ?? $response->header->l11n->language)
            ->where('accounts/l11n/language', $request->getDataString('language') ?? $response->header->l11n->language)
            ->sort('order', OrderType::ASC)
            ->execute();

        $view->data['structures'] = IncomeStatementMapper::getAll()
            ->execute();

        $view->data['languages'] = [];
        if (!empty($view->data['elements'])) {
            $tempL11ns = IncomeStatementElementL11nMapper::getAll()
                ->where('ref', \reset($view->data['elements'])->id)
                ->execute();

            foreach ($tempL11ns as $l11n) {
                $view->data['languages'][] = $l11n->language;
            }
        }

        return $view;
    }
}
