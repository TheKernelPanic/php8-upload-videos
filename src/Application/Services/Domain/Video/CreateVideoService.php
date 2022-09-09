<?php

declare(strict_types=1);

namespace KernelPanicUploadVideo\Application\Services\Domain\Video;

use DateTime;
use KernelPanicUploadVideo\Application\Utils\FilenameGenerator;
use KernelPanicUploadVideo\Domain\Video\Video;

use function count;

/**
 * Class CreateVideoService
 * @package KernelPanicUploadVideo\Application\Services\Domain\Video
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