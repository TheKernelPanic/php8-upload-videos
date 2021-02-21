<?php

declare(strict_types=1);

namespace Src\Infrastructure\Repository;

/**
 * Class Repository
 * @package Src\Infrastructure\Repository
 */
abstract class Repository
{
    /**
     *
     * At this point we could add a dependency for
     * access to a persistence system
     *
     * Repository constructor.
     */
    public function __construct() {}
}