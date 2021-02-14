<?php

declare(strict_types=1);

namespace Src\Infrastructure\HttpController;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class HealthCheckController
 */
final class HealthCheckController extends Controller implements HttpCallableInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $payload = $this->getSerializedPayload(
            data: array(
                      'message' => 'Server running!'
                  )
        );

        $response->getBody()->write($payload);

        return $response->withStatus(code: 200)->withHeader(name: 'Content-Type', value: 'application/json');
    }
}