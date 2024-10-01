<?php

declare(strict_types=1);

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

require_once __DIR__ . '/../vendor/autoload.php';

$request = ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$handler = require __DIR__ . '/../bootstrap/app.php';

$response = $handler($request);
$emitter = new SapiEmitter();
$emitter->emit($response);