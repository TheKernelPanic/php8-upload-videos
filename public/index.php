<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * @var ContainerInterface $container
 */
$container = require_once __DIR__ . '/../bootstrap.php';

$container->get(LoggerInterface::class)->info(message: 'Run server on port 8080');

