<?php declare(strict_types=1);

use Modules\IncomeStatement\Controller\BackendController;
use Modules\IncomeStatement\Models\PermissionState;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/controlling/pl/dashboard.*$' => [
        [
            'dest' => '\Modules\PL\Controller\BackendController:viewPLDashboard',
            'verb' => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'  => PermissionType::READ,
                'state' => PermissionState::DASHBOARD,
            ],
        ],
    ],
];
