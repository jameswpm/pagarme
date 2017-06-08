<?php
require(
    __DIR__ . '/../vendor/autoload.php'
);

use JamesMiranda\Controllers\Fantasy as FantasyController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//config management
$provider = new \werx\Config\Providers\ArrayProvider(__DIR__ . '/../config');
$config = new \werx\Config\Container($provider);


// config twig folder
$twigLoader = new Twig_Loader_Filesystem (
    __DIR__ . '/Views/'
);

$twig = new Twig_Environment($twigLoader, [
    'cache' => '/tmp/twigCache',
    'auto_reload' => true
]);

$request = Request::createFromGlobals();

//configure routes
$dispatcher = FastRoute\simpleDispatcher(
    function (FastRoute\RouteCollector $r) use ($request, $config, $twig) {
        $r->addRoute('GET', '/fantasy/{id:\d+}', 'getFantasyDetail');

        $r->addRoute('POST', '/checkout', 'checkout');

        $r->addRoute('GET', '/hello', function () use ($twig) {
            $controller = new FantasyController();
            
            $response = new Response(
                $twig->render('hello.twig', [
                    
                ])
            );
            $response->send();
        });
    }
);

$routeInfo = $dispatcher->dispatch(
    $request->getMethod(),
    $request->getRequestUri()
);

if (is_callable($routeInfo[1])) {
    $params = ($routeInfo[2]) ?? [];
    $routeInfo[1]($params);
}