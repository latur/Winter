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
        'route' => '/post/{s:slug}',
        'target' => [\Modules\Winter\Controllers\MainController::class, 'post'],
        'name' => 'post'
    ],
];