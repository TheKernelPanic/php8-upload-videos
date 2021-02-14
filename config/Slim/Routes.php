<?php

declare(strict_types=1);

use Slim\App;

return static function (App $app): void {
    $app->get(
        pattern: '/',
        callable: Src\Infrastructure\HttpController\HealthCheckController::class
    );
};