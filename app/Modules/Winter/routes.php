<?php
return [
    # MainController
    [
        'route' => '',
        'target' => [\Modules\Winter\Controllers\MainController::class, 'index'],
        'name' => 'index'
    ],
    [
        'route' => '/login',
        'target' => [\Modules\Winter\Controllers\MainController::class, 'login'],
        'name' => 'login'
    ],
    [
        'route' => '/post/{s:slug}',
        'target' => [\Modules\Winter\Controllers\MainController::class, 'post'],
        'name' => 'post'
    ],


    # AdminController
    [
        'route' => '/drafts',
        'target' => [\Modules\Winter\Controllers\AdminController::class, 'drafts'],
        'name' => 'drafts'
    ],
    [
        'route' => '/stat',
        'target' => [\Modules\Winter\Controllers\AdminController::class, 'stat'],
        'name' => 'stat'
    ],
    [
        'route' => '/settings',
        'target' => [\Modules\Winter\Controllers\AdminController::class, 'settings'],
        'name' => 'settings'
    ],
    [
        'route' => '/editor/{:id}',
        'target' => [\Modules\Winter\Controllers\AdminController::class, 'editor'],
        'name' => 'editor'
    ],


    # ApiController
    [
        'route' => '/api',
        'target' => [\Modules\Winter\Controllers\ApiController::class, 'api'],
        'name' => 'api'
    ],
];
