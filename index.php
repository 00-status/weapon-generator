<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

use Lib\Infrastructure\ReadEffectsService;
use Lib\Infrastructure\ReadWordsService;
use Lib\Service\WeaponGeneratorService;

require __DIR__ . './vendor/autoload.php';

$app = AppFactory::create();

$app->redirect('/index', '/');
$app->get('/', function (Request $request, Response $response, $args) {
    $renderer = new PhpRenderer('./templates');
    return $renderer->render($response,'index.html', $args);
});

$app->get('/api/generate_weapon', function (Request $request, Response $response, $args)
{
    $service = new WeaponGeneratorService(new ReadWordsService(), new ReadEffectsService());
    $result = $service->generateWeapon();
    $response->getBody()->write(json_encode($result));
    return $response;
});

$app->run();
