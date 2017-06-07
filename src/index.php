<?php
require (
    __DIR__ . '/../vendor/autoload.php'
);

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();

$dispatcher = FastRoute\simpleDispatcher(
    function(FastRoute\RouteCollector $r) use ($request) {
        $r->addRoute('GET', '/fantasies', 'getAllFantasies');

        $r->addRoute('GET', '/fantasy/{id:\d+}', 'getFantasy');

        $r->addRoute('POST', '/checkout', 'checkout');

        $r->addRoute('GET', '/hello[/{name}]', function($params) use ($request){
            $name = $params['name'] ?? 'world';
            $response = new Response(
                'Hello ' . $name
            );
            $response->send();
        });
    }
);

$routeInfo = $dispatcher->dispatch(
    $request->getMethod(),
    $request->getRequestUri()
);

if(is_callable($routeInfo[1])) {
    $routeInfo[1]();
}

/*
// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        // ... call $handler with $vars
        break;
}*/