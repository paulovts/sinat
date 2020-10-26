<?php
// Include path
set_include_path(
    implode(
        PATH_SEPARATOR,
        [
            // Composer path
            realpath(dirname(__FILE__) . '/vendor')
        ]
    )
);

session_start();
require_once 'autoload.php';

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;

use App\Controllers;
$container = new Container();

AppFactory::setContainer($container);

$app = AppFactory::create();
require __DIR__ . '/public/includes/class.phpmailer.php';
require __DIR__ . '/public/includes/class.smtp.php';
require './config/routes.php';
$app->addErrorMiddleware(true, true, true);
//$app->add( new App\Middleware\AuthMiddleware($container) );

//$app->add( new App\Middleware\Middleware($container));
//$container->set('flash', fn ($container) => new Slim\Flash\Messages);
$container->set('flash', function ($container) {
    return new  Slim\Flash\Messages;
});

$container->set('auth', function ($container) {
    return new \App\Auth\Auth($container);
});

$container->set('view', function ($container) {
    $view = Twig::create('./src/Views', ['cache' => false]);
    $environment = $view->getEnvironment();
    $environment->addGlobal('flash', $container->get(\Slim\Flash\Messages::class));

    $environment->addGlobal('auth', [
        'check' => $container->get('auth')->check(),
        'usuario' => $container->get('auth')->getUsuario(),
    ]);
    return $view;
});
$app->run();