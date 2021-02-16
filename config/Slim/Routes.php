<?php

declare(strict_types=1);

use Slim\App;

return static function (App $app): void {

    /**
     * Health check
     */
    $app->get(
        pattern: '/',
        callable: Src\Infrastructure\HttpController\HealthCheckController::class
    );

    /**
     * Upload video file
     */
    $app->post(
        pattern: '/uploadVideo',
        callable: Src\Infrastructure\HttpController\UploadVideoController::class
    );
};