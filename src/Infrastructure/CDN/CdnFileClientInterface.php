<?php

declare(strict_types=1);

namespace KernelPanicUploadVideo\Infrastructure\CDN;

/**
 * Class CdnFileClientInterface
 * @package KernelPanicUploadVideo\Infrastructure\CDN
 */
interface CdnFileClientInterface
{
    /**
     * @param string $directory
     * @param string $filename
     * @return bool
     */
    public function exists(string $directory, string $filename): bool;

    /**
     * @param string $directory
     * @param string $filename
     * @param string $sourceFile
     * @param array $metadata
     */
    public function write(string $directory, string $filename, string $sourceFile, array $metadata = []): void;
}