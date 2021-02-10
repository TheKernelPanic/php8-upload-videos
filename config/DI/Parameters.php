<?php

declare(strict_types=1);

use DI\ContainerBuilder;

return static function (ContainerBuilder $containerBuilder): void {
    $parameters = array(
        'parameters' => array(
            'app_name' => $_ENV['APP_NAME'],
            'environment_mode' => $_ENV['ENV_MODE']
        )
    );

    $containerBuilder->addDefinitions(definitions: $parameters);
};