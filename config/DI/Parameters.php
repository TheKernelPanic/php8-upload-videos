<?php

declare(strict_types=1);

use DI\ContainerBuilder;

return static function (ContainerBuilder $containerBuilder): void {
    $parameters = array(
        'parameters' => array(
            'environment_mode' => $_ENV['ENV_MODE'],
            'logger' => array(
                'application_name' => $_ENV['LOGGER_APPLICATION_NAME'],
                'directory' => $_ENV['LOGGER_DIRECTORY'],
                'filename' => $_ENV['LOGGER_FILENAME'],
                'rotation' => $_ENV['LOGGER_ROTATION'] === 'true',
                'file_permission' => 0777
            ),
            'temporally_directory' => $_ENV['TEMPORALLY_DIRECTORY'],
            'messages_agent' => array(
                'host' => $_ENV['RABBITMQ_HOST'],
                'port' => $_ENV['RABBITMQ_PORT'],
                'user' => $_ENV['RABBITMQ_USER'],
                'password' => $_ENV['RABBITMQ_PASSWORD']
            )
        )
    );

    $containerBuilder->addDefinitions(definitions: $parameters);
};