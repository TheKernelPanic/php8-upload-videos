<?php

declare(strict_types=1);

namespace KernelPanicUploadVideo\Application\Services\Domain\Video;

use KernelPanicUploadVideo\Domain\Video\VideoRepositoryInterface;

/**
 * Class VideoDomainService
 * @package KernelPanicUploadVideo\Application\Services\Domain\Video
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