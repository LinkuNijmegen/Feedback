<?php
declare(strict_types=1);

namespace Linku\Feedback;

use Throwable;

final class ChainedFeedback implements Feedback
{
    /**
     * @var Feedback[]
     */
    private $chain;

    public function __construct(Feedback ...$chain)
    {
        $this->chain = $chain;
    }

    public function exception(Throwable $exception): void
    {
        foreach ($this->chain as $feedback) {
            $feedback->exception($exception);
        }
    }

    public function error(string $message): void
    {
        foreach ($this->chain as $feedback) {
            $feedback->error($message);
        }
    }

    public function warning(string $message): void
    {
        foreach ($this->chain as $feedback) {
            $feedback->warning($message);
        }
    }

    public function info(string $message): void
    {
        foreach ($this->chain as $feedback) {
            $feedback->info($message);
        }
    }

    public function success(string $message): void
    {
        foreach ($this->chain as $feedback) {
            $feedback->success($message);
        }
    }

    public function startProcess(int $total = 0): void
    {
        foreach ($this->chain as $feedback) {
            $feedback->startProcess($total);
        }
    }

    public function finishProcess(): void
    {
        foreach ($this->chain as $feedback) {
            $feedback->finishProcess();
        }
    }

    public function advanceProcess(int $steps = 1): void
    {
        foreach ($this->chain as $feedback) {
            $feedback->advanceProcess($steps);
        }
    }
}
