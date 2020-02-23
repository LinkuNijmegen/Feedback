<?php
declare(strict_types=1);

namespace Linku\Feedback;

use Throwable;

interface Feedback
{
    public function exception(Throwable $exception): void;

    public function error(string $message): void;

    public function warning(string $message): void;

    public function info(string $message): void;

    public function success(string $message): void;

    public function startProcess(int $total = 0): void;

    public function finishProcess(): void;

    public function advanceProcess(int $steps = 1): void;
}
