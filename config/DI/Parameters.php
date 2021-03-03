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
            ),
            'aws' => array(
                'configuration' => array(
                    'version' => 'latest',
                    'region' => $_ENV['AWS_REGION'],
                    'credentials' => array(
                        'key' => $_ENV['AWS_CLIENT_ID'],
                        'secret' => $_ENV['AWS_CLIENT_SECRET']
                    )
                ),
                's3_bucket' => $_ENV['AWS_S3_BUCKET']
            ),
            'orm' => array(
                'host' => $_ENV['MARIADB_HOST'],
                'user' => $_ENV['MARIADB_USER'],
                'password' => $_ENV['MARIADB_PASSWORD'],
                'dbname' => $_ENV['MARIADB_DATABASE'],
                'port'  => $_ENV['MARIADB_PORT'],
                'driver' => 'pdo_mysql',
                'charset' => 'utf8'
            )
        )
    );

    $containerBuilder->addDefinitions(definitions: $parameters);
};