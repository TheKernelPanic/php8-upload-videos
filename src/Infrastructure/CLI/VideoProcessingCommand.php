<?php

declare(strict_types=1);

namespace KernelPanicUploadVideo\Infrastructure\CLI;

use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Psr\Log\LoggerInterface;
use KernelPanicUploadVideo\Application\Services\Domain\Video\FinderService;
use KernelPanicUploadVideo\Application\Services\Domain\Video\MarkAsProcessedService;
use KernelPanicUploadVideo\Domain\Video\VideoRepositoryInterface;
use KernelPanicUploadVideo\Infrastructure\CDN\CdnFileClientInterface;
use KernelPanicUploadVideo\Infrastructure\EventStorage\Video\VideoEventStorage;
use KernelPanicUploadVideo\Infrastructure\EventStorage\Video\VideoOnMessageCallable;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class VideoProcessingCommand
 * @package KernelPanicUploadVideo\Infrastructure\CLI
 */
class VideoProcessingCommand extends AppCommand
{
    /**
     * 
     */
    public function configure()
    {
        $this->setName(name: 'process:pending-video-files');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /**
         * Domain services
         */
        $videoRepository = $this->container->get(VideoRepositoryInterface::class);
        $markAsProcessedService = new MarkAsProcessedService(
            repository: $videoRepository
        );
        $finderService = new FinderService(
            repository: $videoRepository
        );

        $onMessageCallable = new VideoOnMessageCallable(
            finderService: $finderService,
            markAsProcessedService: $markAsProcessedService,
            container: $this->container
        );

        /**
         * Consumer
         */
        $videoEventStorage = new VideoEventStorage(
            connection: $this->container->get(AMQPStreamConnection::class)
        );

        $videoEventStorage->consume(onMessageCallable: $onMessageCallable);

        return 0;
    }
}