<?php
declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Load environment variables
 */
$dotenv = new Dotenv();
$dotenv->load(path: __DIR__ . '/.env');