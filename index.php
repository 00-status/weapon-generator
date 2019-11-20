<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

require __DIR__ . './vendor/autoload.php';

$app = AppFactory::create();

$app->redirect('/index', '/');
$app->get('/', function (Request $request, Response $response, $args) {
    $renderer = new PhpRenderer('./templates');
    return $renderer->render($response,'index.html', $args);
});

$app->get('/api/generate_weapon', function (Request $request, Response $response, $args) {
    $response->getBody()->write("A New Weapon");
    return $response;
});

$app->run();
