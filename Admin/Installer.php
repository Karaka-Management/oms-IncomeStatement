<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\IncomeStatement\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\IncomeStatement\Admin;

use Modules\Accounting\Models\AccountAbstract;
use Modules\Accounting\Models\AccountAbstractMapper;
use Modules\IncomeStatement\Controller\ApiController;
use phpOMS\Application\ApplicationAbstract;
use phpOMS\Config\SettingsInterface;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Module\InstallerAbstract;
use phpOMS\Module\ModuleInfo;

/**
 * Installer class.
 *
 * @package Modules\IncomeStatement\Admin
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class Installer extends InstallerAbstract
{
    /**
     * Path of the file
     *
     * @var string
     * @since 1.0.0
     */
    public const PATH = __DIR__;

    /**
     * {@inheritdoc}
     */
    public static function install(ApplicationAbstract $app, ModuleInfo $info, SettingsInterface $cfgHandler) : void
    {
        parent::install($app, $info, $cfgHandler);

        self::importStructures($app);
    }

    /**
     * Import accounts
     *
     * @param ApplicationAbstract $app Application
     *
     * @return void
     *
     * @since 1.0.0
     */
    private static function importStructures(ApplicationAbstract $app) : void
    {
        /** @var \Modules\IncomeStatement\Controller\ApiController $module */
        $module = $app->moduleManager->get('IncomeStatement', 'Api');

        $structures = \scandir(__DIR__ . '/Install/Coa');
        if ($structures === false) {
            return;
        }

        foreach ($structures as $file) {
            if ($file === '..' || $file === '.') {
                continue;
            }

            $response = new HttpResponse();
            $request  = new HttpRequest();

            $request->header->account = 1;
            $request->setData('code', \strtolower(\basename($file, '.json')));
            $request->setData('name', \strtr(\basename($file, '.json'), '_', ' '));

            $module->apiIncomeStatementCreate($request, $response);
            $responseData = $response->getDataArray('');

            $incomeStatement = \is_array($responseData['response'])
                ? $responseData['response']
                : $responseData['response']->toArray();

            $fileContent = \file_get_contents(__DIR__ . '/Install/Coa/' . $file);
            if ($fileContent === false) {
                return;
            }

            /** @var array $json */
            $json = \json_decode($fileContent, true);
            self::createElement($module, $json, (int) $incomeStatement['id'], null);
        }
    }

    /**
     * Create income statement element
     *
     * @param ApiController $module    Module
     * @param array         $elements  Elements to create
     * @param int           $structure Structure the elements belong to
     * @param null|int      $parent    Parent element (null = none)
     *
     * @return void
     *
     * @since 1.0.0
     */
    private static function createElement(ApiController $module, array $elements, int $structure, ?int $parent = null) : void
    {
        $order = 0;
        foreach ($elements as $element) {
            ++$order;

            $response = new HttpResponse();
            $request  = new HttpRequest();

            $request->header->account = 1;
            $request->setData('code', $element['name']);
            $request->setData('content', \reset($element['l11n']));
            $request->setData('language', \array_keys($element['l11n'])[0] ?? 'en');
            $request->setData('formula', $element['formula']);
            $request->setData('style', $element['style']);
            $request->setData('type', $element['type']);
            $request->setData('pl', $structure);
            $request->setData('order', $order);
            $request->setData('expanded', $element['expanded'] ?? false);

            if ($parent !== null) {
                $request->setData('parent', $parent);
            }

            if (!empty($element['account'])) {
                /** @var AccountAbstract[] $accountObjects */
                $accountObjects = AccountAbstractMapper::getAll()
                    ->where('code', \array_map(function($account) {
                        return (string) $account;
                    }, $element['account']), 'IN')
                    ->executeGetArray();

                $request->setData('accounts', \implode(',',
                    \array_map(function (AccountAbstract $account) : int {
                        return $account->id;
                    }, $accountObjects)
                ));
            }

            $module->apiIncomeStatementElementCreate($request, $response);
            $responseData = $response->getDataArray('');

            $incomeStatementElement = \is_array($responseData['response'])
                ? $responseData['response']
                : $responseData['response']->toArray();

            $isFirst = true;
            foreach ($element['l11n'] as $language => $l11n) {
                if ($isFirst) {
                    $isFirst = false;
                    continue;
                }

                $response = new HttpResponse();
                $request  = new HttpRequest();

                $request->header->account = 1;
                $request->setData('content', $l11n);
                $request->setData('language', $language);
                $request->setData('ref', $incomeStatementElement['id']);

                $module->apiIncomeStatementElementL11nCreate($request, $response);
            }

            if (!empty($element['children'])) {
                self::createElement($module, $element['children'], $structure, $incomeStatementElement['id']);
            }
        }
    }
}
