<?php

require_once __DIR__ . '/vendor/autoload.php';

use Core\App;
use Core\Http;

$app = new App("127.0.0.1", 8000);
$app->init();

$app->get('/', function() {
    $data = file_get_contents('todos.json');

    return $data;
});

$app->get('todos', function() {
    $host = parse_url("https://jsonplaceholder.typicode.com")['host'];
    $client = new Http($host);
    $client->addHeaders([
        'Content-Type' => 'application/json'
    ]);
    $client->timeout(1);
    $res = $client->get('/todos');

    return $res;
});

$app->post('/page1', function($request) {
    return $request->getContent();
});

$app->put('/page2', function($request) {

    return $request->getContent();

    return json_encode([
        'page' => 'page 2'
    ]);
});

$app->listen();
