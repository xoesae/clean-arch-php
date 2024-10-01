<?php

declare(strict_types=1);

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

return simpleDispatcher(function (RouteCollector $router) {
    $router->addRoute('GET', '/', 'App\Infrastructure\Http\Controllers\ProposalController@generateProposalReportCsv');
});
