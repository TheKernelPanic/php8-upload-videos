<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Load environment variables
 */
$dotenv = new Dotenv();
$dotenv->load(path: __DIR__ . '/.env');

/**
 * Init DI
 */
$containerBuilder = new ContainerBuilder();

$parameters = __DIR__ . '/config/DI/Parameters.php';
$parameters($containerBuilder);

$dependencies = __DIR__ . '/config/DI/Dependencies.php';
$dependencies($containerBuilder);
