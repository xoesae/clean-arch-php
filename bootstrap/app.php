<?php

declare(strict_types=1);

use Laminas\Diactoros\Response\JsonResponse;

$container = require __DIR__ . '/../config/container.php';
$dispatcher = require __DIR__ . '/../config/routes.php';

return function ($request) use ($container, $dispatcher) {
    $httpMethod = $request->getMethod();
    $uri = $request->getUri()->getPath();

    if (false !== $pos = strpos($uri, '?')) {
        $uri = substr($uri, 0, $pos);
    }
    $uri = rawurldecode($uri);

    $route = $dispatcher->dispatch($httpMethod, $uri);

    switch ($route[0]) {
        case FastRoute\Dispatcher::NOT_FOUND:
            $response = new JsonResponse(['error' => '404 - Not Found'], 404);
            break;
        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            $response = new JsonResponse(['error' => '405 - Method Not Allowed'], 405);
            break;
        case FastRoute\Dispatcher::FOUND:
            $handler = $route[1];
            $vars = $route[2];

            [$class, $method] = explode('@', $handler);
            $controller = $container->get($class);

            $response = $controller->$method($request, $vars);
            break;
        default:
            $response = new JsonResponse(['error' => '404 - Not Found'], 404);
    }

    return $response;
};