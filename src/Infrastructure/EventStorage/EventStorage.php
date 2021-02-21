<?php

declare(strict_types=1);

namespace Src\Infrastructure\EventStorage;

use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class EventStorage
 * @package Src\Infrastructure\EventStorage
 */
abstract class EventStorage
{
    /**
     * @var string
     */
    protected string $exchange = '';

    /**
     * @var string
     */
    protected string $queue = '';

    /**
     * @var string
     */
    protected string $routingKey = '';

    /**
     * @var string
     */
    protected string $exchangeType = 'direct';

    /**
     * @var array|string[]
     */
    protected array $messageCommonProperties = array(
        'content_type' => 'application/json'
    );

    /**
     * EventStorage constructor.
     * @param AMQPStreamConnection $connection
     */
    public function __construct(
        protected AMQPStreamConnection $connection
    ) {
    }

    /**
     * @return AMQPChannel
     */
    protected function getChannel(): AMQPChannel
    {
        $channel = $this->connection->channel();

        $channel->exchange_declare(
            exchange: $this->exchange,
            type: $this->exchangeType
        );
        $channel->queue_declare(
            queue: $this->queue,
            auto_delete: false
        );
        $channel->queue_bind(
            queue: $this->queue,
            exchange: $this->exchange,
            routing_key: $this->routingKey
        );
        return $channel;
    }

    /**
     * @param OnMessageCallableInterface $onMessageCallable
     */
    public function consume(OnMessageCallableInterface $onMessageCallable, string $consumerTag = ''): void
    {
        $channel = $this->getChannel();

        $channel->basic_consume(
            queue: $this->queue,
            consumer_tag: $consumerTag,
            callback: $onMessageCallable
        );

        while ($channel->is_consuming()) {
            $channel->wait();
        }
        $channel->close();
    }

    /**
     * @param string $payload
     * @return AMQPMessage
     */
    private function getMessage(string $payload): AMQPMessage
    {
        return new AMQPMessage(
            body: $payload,
            properties: $this->messageCommonProperties
        );
    }

    /**
     * @param string $payload
     */
    public function produce(string $payload): void
    {
        $channel = $this->getChannel();

        $channel->basic_publish(
            msg: $this->getMessage(payload: $payload),
            exchange: $this->exchange,
            routing_key: $this->routingKey
        );
        $channel->close();
    }

    /**
     * @throws Exception
     */
    public function __destruct()
    {
        $this->connection->close();
    }
}