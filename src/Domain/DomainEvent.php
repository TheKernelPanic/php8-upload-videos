<?php
declare(strict_types=1);

namespace KernelPanicUploadVideo\Domain;

use DateTimeInterface;

interface DomainEvent
{
    /**
     * @return DateTimeInterface
     */
    public function occurredOn(): DateTimeInterface;
}