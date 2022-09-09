<?php
declare(strict_types=1);

namespace KernelPanicUploadVideo\Domain;

class DomainEventPublisher
{
    /**
     * @var array
     */
    private array $listeners;

    /**
     * @var DomainEventPublisher|null
     */
    private static ?DomainEventPublisher $instance = null;

    /**
     * @var int
     */
    private int $id = 0;

    private function __construct()
    {
    }

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        if (is_null(static::$instance)) {
            static::$instance = new self();
        }
        return static::$instance;
    }

    /**
     * @return void
     */
    public function __clone(): void
    {
        throw new \BadMethodCallException(
            message: 'Clone is not supported'
        );
    }

    /**
     * @param DomainEventListener $domainEventListener
     * @return int
     */
    public function addListener(DomainEventListener $domainEventListener): int
    {
        $id = $this->id;
        $this->listeners[$id] = $domainEventListener;
        $this->id++;

        return $id;
    }

    /**
     * @param int $id
     * @return int|null
     */
    public function getListenerById(int $id): ?int
    {
        return $this->listeners[$id] ?? null;
    }

    /**
     * @param int $id
     * @return void
     */
    public function removeListener(int $id): void
    {
        unset($this->listeners[$id]);
    }

    /**
     * @param DomainEvent $domainEvent
     * @return void
     */
    public function publish(DomainEvent $domainEvent): void
    {
        foreach ($this->listeners as $listener) {
            if ($listener->isListenTo($domainEvent)) {
                $listener->handle($domainEvent);
            }
        }
    }
}