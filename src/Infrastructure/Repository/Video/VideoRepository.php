<?php

declare(strict_types=1);

namespace Src\Infrastructure\Repository\Video;

use Ramsey\Uuid\Uuid;
use Src\Domain\Video\Video;
use Src\Domain\Video\VideoRepositoryInterface;
use Src\Infrastructure\Repository\Repository;

/**
 * Class VideoRepositoryInterface
 * @package Src\Infrastructure\Repository
 */
final class VideoRepository extends Repository implements VideoRepositoryInterface
{
    /**
     * @param Video $video
     * @return Video
     */
    public function save(Video $video): Video
    {
        $uuidV4Generated =Uuid::uuid4()->toString();
        /**
         * Mock persistent system
         */
        $video->setId(id: $uuidV4Generated);

        return $video;
    }

    /**
     * @param int|string $id
     * @return Video|null
     */
    public function findById(int|string $id): ?Video
    {
        // TODO: Implement findById() method.
    }

    /**
     * @param array $criteria
     * @return array
     */
    public function findByCriteria(array $criteria): array
    {
        return [];
    }
}