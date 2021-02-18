<?php

declare(strict_types=1);

namespace Src\Domain\Video;

use DateTimeInterface;

/**
 * Class Video
 * @package Src\Domain\Video
 */
class Video
{
    /**
     * @var string|int
     */
    private string|int $id;

    /**
     * @var DateTimeInterface|null
     */
    private ?DateTimeInterface $processedAt;

    /**
     * Video constructor.
     * @param string $filename
     * @param DateTimeInterface $createdAt
     */
    public function __construct(
        private string $filename,
        private DateTimeInterface $createdAt
    ) {
    }

    /**
     * @return string|int
     */
    public function getId(): string|int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getProcessedAt(): ?DateTimeInterface
    {
        return $this->processedAt;
    }

    /**
     * @param DateTimeInterface|null $processedAt
     */
    public function setProcessedAt(?DateTimeInterface $processedAt): void
    {
        $this->processedAt = $processedAt;
    }
}