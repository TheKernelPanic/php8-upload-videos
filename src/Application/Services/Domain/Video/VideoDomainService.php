<?php

declare(strict_types=1);

namespace Src\Application\Services\Domain\Video;

use Src\Domain\Video\VideoRepositoryInterface;

/**
 * Class VideoDomainService
 * @package Src\Application\Services\Domain\Video
 */
abstract class VideoDomainService
{
    /**
     * VideoDomainService constructor.
     * @param VideoRepositoryInterface $repository
     */
    public function __construct(
        protected VideoRepositoryInterface $repository
    ) {
    }
}