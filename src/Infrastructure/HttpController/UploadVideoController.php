<?php

declare(strict_types=1);

namespace Src\Infrastructure\HttpController;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Psr7\UploadedFile;

use function is_dir;
use function is_writable;
use function array_key_exists;

/**
 * Class UploadVideoController
 * @package Src\Infrastructure\HttpController
 */
class UploadVideoController extends Controller implements HttpCallableInterface
{
    private const VIDEO_PARAMETER = 'video';

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws HttpBadRequestException
     * @throws HttpInternalServerErrorException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if (!array_key_exists(self::VIDEO_PARAMETER, $request->getUploadedFiles())) {
            throw new HttpBadRequestException(
                request: $request,
                message: 'Video not found on request body'
            );
        }

        /**
         * @var UploadedFile $uploadedFile
         */
        $uploadedFile = $request->getUploadedFiles()[self::VIDEO_PARAMETER];

        $temporallyDirectoryPath = $this->container->get('parameters')['temporally_directory'];

        if (!is_dir($temporallyDirectoryPath) || !is_writable($temporallyDirectoryPath)) {
            throw new HttpInternalServerErrorException(
                request: $request,
                message: 'Cannot write on temporally directory'
            );
        }

        $uploadedFile->moveTo(targetPath: "{$temporallyDirectoryPath}/{$uploadedFile->getClientFilename()}");

        return $response->withStatus(code: 201);
    }
}