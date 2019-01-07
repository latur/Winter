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

    # AuthController
    [
        'route' => '/drafts',
        'target' => [\Modules\Winter\Controllers\AuthController::class, 'drafts'],
        'name' => 'drafts'
    ],
    [
        'route' => '/stat',
        'target' => [\Modules\Winter\Controllers\AuthController::class, 'stat'],
        'name' => 'stat'
    ],
    [
        'route' => '/editor/{:id}',
        'target' => [\Modules\Winter\Controllers\AuthController::class, 'editor'],
        'name' => 'editor'
    ],

    [
        'route' => '/api',
        'target' => [\Modules\Winter\Controllers\AuthController::class, 'api'],
        'name' => 'api'
    ],


    [
        'route' => '/upload/image',
        'target' => [\Modules\Winter\Controllers\AuthController::class, 'image'],
        'name' => 'image'
    ],
    [
        'route' => '/upload/file',
        'target' => [\Modules\Winter\Controllers\AuthController::class, 'file'],
        'name' => 'file'
    ],
    [
        'route' => '/save',
        'target' => [\Modules\Winter\Controllers\AuthController::class, 'save'],
        'name' => 'save'
    ],
    [
        'route' => '/create',
        'target' => [\Modules\Winter\Controllers\AuthController::class, 'create'],
        'name' => 'create'
    ],
    [
        'route' => '/logout',
        'target' => [\Modules\Winter\Controllers\AuthController::class, 'logout'],
        'name' => 'logout'
    ],
];
