<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\IncomeStatement\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\IncomeStatement\Admin;

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
        $module = $app->moduleManager->getModuleInstance('IncomeStatement', 'Api');

        $structures = \scandir(__DIR__ . '/Install/Coa');
        foreach ($structures as $file) {
            if ($file === '..' || $file === '.') {
                continue;
            }

            $response = new HttpResponse();
            $request  = new HttpRequest();

            $request->header->account = 1;
            $request->setData('code', \strtolower(\basename($file)));
            $request->setData('name', \strtr(\basename($file), '_', ' '));

            $module->apiIncomeStatementCreate($request, $response);
            $responseData = $response->getData('');

            $incomeStatement = \is_array($responseData['response'])
                ? $responseData['response']
                : $responseData['response']->toArray();

            $json = \json_decode(\file_get_contents(__DIR__ . '/Install/Coa/' . $file), true);
            self::createElement($module, $json, (int) $incomeStatement['id'], null);
        }
    }

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
            $request->setData('accounts', \implode(',', $element['account']));
            $request->setData('formula', $element['formula']);
            $request->setData('type', $element['type']);
            $request->setData('pl', $structure);
            $request->setData('order', $order);

            if ($parent !== null) {
                $request->setData('parent', $parent);
            }

            $module->apiIncomeStatementElementCreate($request, $response);
            $responseData = $response->getData('');

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
                $request->setData('title', $l11n);
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
