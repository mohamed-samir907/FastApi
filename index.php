<?php

require_once __DIR__ . '/vendor/autoload.php';

use FastApi\Core\App;
use FastApi\Facades\Route;

$app = new App("127.0.0.1", 8000);
$app->init(true);

Route::get('/', function () {
    return json_encode([
        'msg' => 'Welcome to FastApi Framework',
    ]);
});

Route::get('/users', function () {
    return json_encode([
        ['id' => 1, 'name' => 'mohamed'],
        ['id' => 2, 'name' => 'samir']
    ]);
});

Route::post('/users/{id}/edit', function ($id) {
    return json_encode([
        'msg' => 'edit',
        'id' => $id
    ]);
});

Route::get('/users/{id}/edit/{user}', function () {
    return json_encode([
        'msg' => 'msg',
    ]);
});

Route::get('/users/{id}/edit/{user}/{user2}', function () {
    return json_encode([
        'msg' => 'msg2',
    ]);
});

$app->listen();
