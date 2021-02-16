<?php

declare(strict_types=1);

namespace Src\Domain\Video;

/**
 * Interface VideoRepositoryInterface
 * @package Src\Domain\Video
 */
interface VideoRepositoryInterface
{
    /**
     * @param Video $video
     * @return Video
     */
    public function save(Video $video): Video;

    /**
     * @param string|int $id
     * @return Video|null
     */
    public function findById(string|int $id): ?Video;
}