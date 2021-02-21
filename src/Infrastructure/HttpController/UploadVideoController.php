<?php

declare(strict_types=1);

namespace Src\Infrastructure\HttpController;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPRuntimeException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Psr7\UploadedFile;

use Src\Application\Services\Domain\Video\CreateVideoService;
use Src\Domain\Video\VideoRepositoryInterface;
use Src\Infrastructure\EventStorage\Video\VideoEventStorage;

use function is_dir;
use function is_writable;
use function array_key_exists;
use function json_encode;

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
                request: $request, message: 'Video not found on request body'
            );
        }

        /**
         * @var UploadedFile $uploadedFile
         */
        $uploadedFile = $request->getUploadedFiles()[self::VIDEO_PARAMETER];

        $temporallyDirectoryPath = $this->container->get('parameters')['temporally_directory'];

        if (!is_dir($temporallyDirectoryPath) || !is_writable($temporallyDirectoryPath)) {
            throw new HttpInternalServerErrorException(
                request: $request, message: 'Cannot write on temporally directory'
            );
        }

        $uploadedFile->moveTo(
            targetPath: $pendingVideoPath = "{$temporallyDirectoryPath}/{$uploadedFile->getClientFilename()}"
        );

        /**
         * Persist a new video
         */
        $createVideoService = new CreateVideoService(
            repository: $this->container->get(VideoRepositoryInterface::class)
        );
        $video = $createVideoService();

        try {
            /**
             * Publish event
             */
            $videoEventStorage = new VideoEventStorage(
                connection: $this->container->get(AMQPStreamConnection::class)
            );

            $payload = json_encode(
                array(
                    'pending_video_path' => $pendingVideoPath,
                    'video_id'           => $video->getId()
                )
            );

            $videoEventStorage->produce(payload: $payload);

        } catch (AMQPRuntimeException $exception) {
            throw new HttpInternalServerErrorException(
                request: $request,
                message: $exception->getMessage()
            );
        }

        return $response->withStatus(code: 201);
    }
}