<?php

declare(strict_types=1);

namespace Src\Infrastructure\EventStorage\Video;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Src\Infrastructure\EventStorage\EventStorage;

/**
 * Class VideoEventStorage
 * @package Src\Infrastructure\EventStorage\Video
 */
class VideoEventStorage extends EventStorage
{
    /**
     * VideoEventStorage constructor.
     * @param AMQPStreamConnection $connection
     */
    public function __construct(AMQPStreamConnection $connection)
    {
        $this->exchange = 'upload';
        $this->queue = 'video.uploaded.process';
        $this->routingKey = 'upload.video';

        parent::__construct(connection: $connection);
    }
}