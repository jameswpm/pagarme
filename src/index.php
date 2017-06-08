<?php
require(
    __DIR__ . '/../vendor/autoload.php'
);

use JamesMiranda\Services\{
    DoctrineService, TwigService
};
use JamesMiranda\Controllers\Fantasy as FantasyController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//config management
$provider = new \werx\Config\Providers\ArrayProvider(__DIR__ . '/../config');
$config = new \werx\Config\Container($provider);

//container for dependency injection
$container = new League\Container\Container;
$container->add('DoctrineService', DoctrineService::class);
$container->add('TwigService', TwigService::class);

$request = Request::createFromGlobals();

//configure routes
$dispatcher = FastRoute\simpleDispatcher(
    function (FastRoute\RouteCollector $r) use ($request, $config, $container) {
        $twigService = $container->get('TwigService');
        $twig = $twigService->getTwig();
        $doctrine = $container->get('DoctrineService');
        $em = $doctrine->getEm();

        //MAIN PAGE ROUTE
        $r->addRoute('GET', '/hello', function () use ($twig, $em) {

            $controller = new FantasyController($em);
            $fantasies = $controller->allFantasies();

            $response = new Response (
                $twig->render('hello.twig', [
                    'fantasies' => $fantasies
                ])
            );
            $response->send();
        });

        $r->addRoute('GET', '/fantasy/{id:\d+}', 'getFantasyDetail');

        $r->addRoute('POST', '/checkout', 'checkout');
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