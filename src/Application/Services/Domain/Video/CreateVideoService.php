<?php

declare(strict_types=1);

namespace Src\Application\Services\Domain\Video;

use DateTime;
use Src\Application\Utils\FilenameGenerator;
use Src\Domain\Video\Video;

use function count;

/**
 * Class CreateVideoService
 * @package Src\Application\Services\Domain\Video
 */
final class CreateVideoService extends VideoDomainService
{
    /**
     * @return Video
     */
    public function __invoke(): Video
    {
        $filename = FilenameGenerator::generate(extension: 'mp4');

        /**
         * Find
         */
        while (count($this->repository->findByCriteria(criteria: array('filename' => $filename)))) {
            $filename = FilenameGenerator::generate(extension: 'mp4');
        }

        $video = new Video(
            filename: $filename, createdAt: new DateTime()
        );

        return $this->repository->save(video: $video);
    }
}