<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;
use Src\Application\Handler\HttpErrorHandler;
use Src\Application\Handler\ShutdownHandler;

/**
 * @var ContainerInterface $container
 */
$container = require_once __DIR__ . '/../bootstrap.php';

$container->get(LoggerInterface::class)->info(message: 'Run server on port 8080');

/**
 * Init Slim App
 */
AppFactory::setContainer(container: $container);
$app = AppFactory::create();
$callable = $app->getCallableResolver();

/**
 * Register routes
 */
$routes = require_once __DIR__ . '/../config/Slim/Routes.php';
$routes(app: $app);

$request = ServerRequestCreatorFactory::create()->createServerRequestFromGlobals();

/**
 * Http error handler & shutdown handler
 */
$httpErrorHandler = new HttpErrorHandler(
    callableResolver: $callable,
    responseFactory: $app->getResponseFactory(),
    logger: $container->get(LoggerInterface::class)
);
$shutdownHandler = new ShutdownHandler(
    request: $request,
    httpErrorHandler: $httpErrorHandler,
    displayErrorDetails: false
);
register_shutdown_function($shutdownHandler);

$errorMiddleware = $app->addErrorMiddleware(
    displayErrorDetails: false,
    logErrors:  false,
    logErrorDetails: false
);
$errorMiddleware->setDefaultErrorHandler(handler: $httpErrorHandler);

$app->run();