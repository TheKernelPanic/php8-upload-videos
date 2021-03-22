<?php

declare(strict_types=1);

namespace Src\Infrastructure\CLI;


use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;

/**
 * Class AppCommand
 * @package Src\Infrastructure\CLI
 */
abstract class AppCommand extends Command
{
    /**
     * VideoProcessingCommand constructor.
     * @param ContainerInterface $container
     */
    public function __construct(
        protected ContainerInterface $container
    ) {
        parent::__construct(name: null);
    }
}