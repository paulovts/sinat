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
use Slim\Factory\AppFactory;
use Slim\Views\Twig;

// Define application environment
define('API_BASE_URL', ($_SERVER['API_BASE_URL'] ? $_SERVER['API_BASE_URL'] : 'http://localhost:8081'));
define('APP_BASE_PATH', ($_SERVER['APP_BASE_PATH'] ? $_SERVER['APP_BASE_PATH'] : '/sinat'));
define('APP_ENV', ($_SERVER['APP_ENV'] ? $_SERVER['APP_ENV'] : 'dev'));

$container = new Container();
AppFactory::setContainer($container);

$app = AppFactory::create();

if (getenv('APP_BASE_PATH')) {
    $app->setBasePath(getenv('APP_BASE_PATH'));
}
//$app->setBasePath('/sinat');
require __DIR__ . '/public/includes/class.phpmailer.php';
require __DIR__ . '/public/includes/class.smtp.php';
require './config/routes.php';
$app->addErrorMiddleware(true, true, true);

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