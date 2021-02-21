<?php

declare(strict_types=1);

namespace Src\Infrastructure\EventStorage;

use PhpAmqpLib\Message\AMQPMessage;

/**
 * Interface OnMessageCallableInterface
 * @package Src\Infrastructure\EventStorage
 */
interface OnMessageCallableInterface
{
    /**
     * @param AMQPMessage $message
     */
    public function __invoke(AMQPMessage $message): void;
}