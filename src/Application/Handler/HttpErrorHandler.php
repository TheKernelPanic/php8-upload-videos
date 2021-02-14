<?php

declare(strict_types=1);

namespace Src\Application\Handler;

use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpNotImplementedException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Handlers\ErrorHandler;

/**
 * Class HttpErrorHandler
 * @package Src\Application\Handler
 */
class HttpErrorHandler extends ErrorHandler
{
    public const BAD_REQUEST = 'BAD_REQUEST';
    public const NOT_ALLOWED = 'NOT_ALLOWED';
    public const NOT_IMPLEMENTED = 'NOT_IMPLEMENTED';
    public const RESOURCE_NOT_FOUND = 'RESOURCE_NOT_FOUND';
    public const SERVER_ERROR = 'SERVER_ERROR';
    public const UNAUTHENTICATED = 'UNAUTHENTICATED';

    /**
     * @return ResponseInterface
     */
    protected function respond(): ResponseInterface
    {
        switch (true) {
            case $this->exception instanceof HttpNotFoundException:
                $type = self::RESOURCE_NOT_FOUND;
                $httpStatusCode = 404;
                break;

            case $this->exception instanceof HttpMethodNotAllowedException:
                $type = self::NOT_ALLOWED;
                $httpStatusCode = 405;
                break;

            case $this->exception instanceof HttpUnauthorizedException:
                $type = self::UNAUTHENTICATED;
                $httpStatusCode = 401;
                break;

            case $this->exception instanceof HttpForbiddenException:
                $type = self::UNAUTHENTICATED;
                $httpStatusCode = 403;
                break;

            case $this->exception instanceof HttpBadRequestException:
                $type = self::BAD_REQUEST;
                $httpStatusCode = 400;
                break;

            case $this->exception instanceof HttpNotImplementedException:
                $type = self::NOT_IMPLEMENTED;
                $httpStatusCode = 501;
                break;
            default:
                $type = self::SERVER_ERROR;
                $httpStatusCode = 500;
        }

        $this->logger->error(message: $this->exception->getMessage());

        $error = [
            'error' => $type
        ];

        $payload = json_encode($error, JSON_PRETTY_PRINT);

        $response = $this->responseFactory->createResponse(code: $httpStatusCode);
        $response->getBody()->write(string: $payload);

        return $response
                ->withStatus(code: $httpStatusCode);
    }
}