<?php
return [
    [
        'route' => '',
        'target' => [\Modules\Winter\Controllers\MainController::class, 'index'],
        'name' => 'index'
    ],

    [
        'route' => '/upload',
        'target' => [\Modules\Winter\Controllers\MainController::class, 'upload'],
        'name' => 'upload'
    ],
    [
        'route' => '/save',
        'target' => [\Modules\Winter\Controllers\MainController::class, 'save'],
        'name' => 'save'
    ],

    [
        'route' => '/post/{s:slug}',
        'target' => [\Modules\Winter\Controllers\MainController::class, 'post'],
        'name' => 'post'
    ],
];