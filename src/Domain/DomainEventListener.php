<?php
declare(strict_types=1);

namespace KernelPanicUploadVideo\Domain;

interface DomainEventListener
{
    /**
     * @param DomainEvent $domainEvent
     * @return void
     */
    public function handle(DomainEvent $domainEvent): void;

    /**
     * @param DomainEvent $domainEvent
     * @return bool
     */
    public function isListenTo(DomainEvent $domainEvent): bool;
}