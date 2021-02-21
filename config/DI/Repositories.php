<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Src\Domain\Video\VideoRepositoryInterface;
use Src\Infrastructure\Repository\Video\VideoRepository;

return static function (ContainerBuilder $containerBuilder): void {
    $containerBuilder->addDefinitions(
        array(
            VideoRepositoryInterface::class => static function (): VideoRepositoryInterface {
                return new VideoRepository();
            }
        )
    );
};