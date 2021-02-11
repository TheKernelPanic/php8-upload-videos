<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return static function (ContainerBuilder $containerBuilder): void {
    $definitions = array(

        /**
         * Logger
         */
        LoggerInterface::class => static function (ContainerInterface $container): LoggerInterface {
            $parameters   = $container->get('parameters')['logger'];
            $logger       = new Logger(name: $parameters['application_name']);
            $absolutePath = $parameters['directory'] . '/' . $parameters['filename'] . '.log';

            $handlerClass = $parameters['rotation'] ? RotatingFileHandler::class : StreamHandler::class;

            $handler = new $handlerClass(
                filename: $absolutePath, level: Logger::DEBUG, filePermission: $parameters['file_permission']
            );

            $logger->pushHandler(handler: $handler);

            return $logger;
        }
    );

    $containerBuilder->addDefinitions(definitions: $definitions);
};