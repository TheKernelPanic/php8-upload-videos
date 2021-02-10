<?php

declare(strict_types=1);

use DI\ContainerBuilder;

return static function (ContainerBuilder $containerBuilder): void {
    $definitions = array();

    $containerBuilder->addDefinitions(definitions: $definitions);
};