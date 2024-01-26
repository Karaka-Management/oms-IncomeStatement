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

use Modules\IncomeStatement\Models\IncomeStatement;
use Modules\IncomeStatement\Models\IncomeStatementElement;
use Modules\IncomeStatement\Models\IncomeStatementElementL11nMapper;
use Modules\IncomeStatement\Models\IncomeStatementElementMapper;
use Modules\IncomeStatement\Models\IncomeStatementMapper;
use phpOMS\Localization\BaseStringL11n;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;

/**
 * IncomeStatement api controller class.
 *
 * @package Modules\IncomeStatement
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class ApiController extends Controller
{
    /**
     * Api method to create an pl
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiIncomeStatementCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateIncomeStatementCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $pl = $this->createIncomeStatementFromRequest($request);
        $this->createModel($request->header->account, $pl, IncomeStatementMapper::class, 'pl', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $pl);
    }

    /**
     * Validate pl create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateIncomeStatementCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['code'] = !$request->hasData('code'))
            || ($val['name'] = !$request->hasData('name'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Method to create pl from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return IncomeStatement
     *
     * @since 1.0.0
     */
    private function createIncomeStatementFromRequest(RequestAbstract $request) : IncomeStatement
    {
        $pl       = new IncomeStatement();
        $pl->code = (string) $request->getData('code');
        $pl->name = (string) $request->getData('name');

        return $pl;
    }

    /**
     * Api method to create an account
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiIncomeStatementElementCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateIncomeStatementElementCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $element = $this->createIncomeStatementElementFromRequest($request);
        $this->createModel($request->header->account, $element, IncomeStatementElementMapper::class, 'pl_element', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $element);
    }

    /**
     * Validate account create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateIncomeStatementElementCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['pl'] = !$request->hasData('pl'))
            || ($val['code'] = !$request->hasData('code'))
            || ($val['content'] = !$request->hasData('content'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Method to create account from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return IncomeStatementElement
     *
     * @since 1.0.0
     */
    private function createIncomeStatementElementFromRequest(RequestAbstract $request) : IncomeStatementElement
    {
        $element                  = new IncomeStatementElement();
        $element->code            = $request->getDataString('code') ?? '';
        $element->incomeStatement = $request->getDataInt('pl') ?? 0;
        $element->order           = $request->getDataInt('order') ?? 0;
        $element->parent          = $request->getDataInt('parent');

        $element->setL11n(
            $request->getDataString('content') ?? '',
            ISO639x1Enum::tryFromValue($request->getDataString('language')) ?? ISO639x1Enum::_EN
        );

        return $element;
    }

    /**
     * Api method to create item attribute l11n
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiIncomeStatementElementL11nCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateIncomeStatementElementL11nCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $elementL11n = $this->createIncomeStatementElementL11nFromRequest($request);
        $this->createModel($request->header->account, $elementL11n, IncomeStatementElementL11nMapper::class, 'pl_element_l11n', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $elementL11n);
    }

    /**
     * Method to create item attribute l11n from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return BaseStringL11n
     *
     * @since 1.0.0
     */
    private function createIncomeStatementElementL11nFromRequest(RequestAbstract $request) : BaseStringL11n
    {
        $elementL11n           = new BaseStringL11n();
        $elementL11n->ref      = $request->getDataInt('ref') ?? 0;
        $elementL11n->language = ISO639x1Enum::tryFromValue($request->getDataString('language')) ?? $request->header->l11n->language;
        $elementL11n->content  = $request->getDataString('content') ?? '';

        return $elementL11n;
    }

    /**
     * Validate item attribute l11n create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateIncomeStatementElementL11nCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['content'] = !$request->hasData('content'))
            || ($val['ref'] = !$request->hasData('ref'))
        ) {
            return $val;
        }

        return [];
    }
}
