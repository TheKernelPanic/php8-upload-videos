<?php

declare(strict_types=1);

namespace KernelPanicUploadVideo\Infrastructure\EventStorage\Video;

use JetBrains\PhpStorm\Pure;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use KernelPanicUploadVideo\Infrastructure\EventStorage\EventStorage;

/**
 * Class VideoEventStorage
 * @package KernelPanicUploadVideo\Infrastructure\EventStorage\Video
 */
class VideoEventStorage extends EventStorage
{
    /**
     * VideoEventStorage constructor.
     * @param AMQPStreamConnection $connection
     */
    #[Pure] public function __construct(AMQPStreamConnection $connection)
    {
        $this->exchange = 'upload';
        $this->queue = 'video.uploaded.process';
        $this->routingKey = 'upload.video';

        parent::__construct(connection: $connection);
    }
}