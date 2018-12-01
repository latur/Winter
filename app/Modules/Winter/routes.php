<?php
return [
    # MainController
    [
        'route' => '',
        'target' => [\Modules\Winter\Controllers\MainController::class, 'index'],
        'name' => 'index'
    ],
    [
        'route' => '/post/{s:slug}',
        'target' => [\Modules\Winter\Controllers\MainController::class, 'post'],
        'name' => 'post'
    ],

    # AuthController
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
];
