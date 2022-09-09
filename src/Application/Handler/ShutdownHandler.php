<?php

declare(strict_types=1);

namespace KernelPanicUploadVideo\Application\Handler;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\ResponseEmitter;

/**
 * Class ShutdownHandler
 * @package KernelPanicUploadVideo\Application\Handler
 */
class ShutdownHandler
{
    /**
     * ShutdownHandler constructor.
     * @param ServerRequestInterface $request
     * @param HttpErrorHandler $httpErrorHandler
     * @param bool $displayErrorDetails
     * @param bool $logErrors
     * @param bool $logErrorDetails
     */
    public function __construct(
        private ServerRequestInterface $request,
        private HttpErrorHandler $httpErrorHandler,
        private bool $displayErrorDetails,
        private bool $logErrors = false,
        private bool $logErrorDetails = false
    ){}

    /**
     *
     */
    public function __invoke(): void
    {
        $error = error_get_last();

        if (!$error) {
            return;
        }

        $exception = new HttpInternalServerErrorException(
            request: $this->request,
            message: $error['message']
        );
        $response = $this->httpErrorHandler->__invoke(
            request: $this->request,
            exception: $exception,
            displayErrorDetails: $this->displayErrorDetails,
            logErrors: $this->logErrors,
            logErrorDetails: $this->logErrorDetails
        );

        if (ob_get_length()) {
            ob_clean();
        }

        $responseEmitter = new ResponseEmitter();
        $responseEmitter->emit(response: $response);
    }
}