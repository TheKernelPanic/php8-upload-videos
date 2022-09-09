<?php

declare(strict_types=1);

namespace KernelPanicUploadVideo\Infrastructure\HttpController;

use Psr\Container\ContainerInterface;

use function json_encode;

/**
 * Class Controller
 */
abstract class Controller
{
    /**
     * Controller constructor.
     * @param ContainerInterface $container
     */
    public function __construct(
        protected ContainerInterface $container
    ) {
    }

    /**
     * @param array $data
     * @return string
     */
    protected function getSerializedPayload(array $data): string
    {
        return json_encode($data, JSON_PRETTY_PRINT);
    }
}