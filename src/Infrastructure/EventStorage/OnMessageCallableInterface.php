<?php

declare(strict_types=1);

namespace KernelPanicUploadVideo\Infrastructure\EventStorage;

use PhpAmqpLib\Message\AMQPMessage;

/**
 * Interface OnMessageCallableInterface
 * @package KernelPanicUploadVideo\Infrastructure\EventStorage
 */
interface OnMessageCallableInterface
{
    /**
     * @param AMQPMessage $message
     */
    public function __invoke(AMQPMessage $message): void;
}