<?php
declare(strict_types=1);

namespace Linku\Feedback;

use Psr\Log\LoggerInterface;
use Throwable;

final class LoggerFeedback implements Feedback
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function exception(Throwable $exception): void
    {
        $this->logger->error($exception->getMessage());
    }

    public function error(string $message): void
    {
        $this->logger->error($message);
    }

    public function warning(string $message): void
    {
        $this->logger->warning($message);
    }

    public function info(string $message): void
    {
        $this->logger->info($message);
    }

    public function success(string $message): void
    {
        $this->logger->info($message);
    }

    public function startProcess(int $total = 0): void
    {
        $this->logger->info('Process '.($total?'of '.$total.' ':'').'started');
    }

    public function finishProcess(): void
    {
        $this->logger->info('Process stopped');
    }

    public function advanceProcess(int $steps = 1): void
    {
        $this->logger->debug('Process advanced with '.$steps);
    }
}
