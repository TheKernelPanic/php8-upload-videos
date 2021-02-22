<?php

declare(strict_types=1);

namespace Src\Application\Services\Domain\Video;

use DateTime;
use Src\Domain\Video\Video;

/**
 * Class MarkAsProcessedService
 * @package Src\Application\Services\Domain\Video
 */
final class MarkAsProcessedService extends VideoDomainService
{
    /**
     * @param Video $video
     * @return Video
     */
    public function __invoke(Video $video): Video
    {
        $video->setProcessedAt(processedAt: new DateTime);
        return $this->repository->save(video: $video);
    }
}