<?php
declare(strict_types=1);

namespace Linku\Feedback;

use Closure;
use Throwable;

final class ClosureFeedback implements Feedback
{
    /**
     * @var Closure
     */
    private $exceptionClosure;

    /**
     * @var Closure
     */
    private $errorClosure;

    /**
     * @var Closure
     */
    private $warningClosure;

    /**
     * @var Closure
     */
    private $infoClosure;

    /**
     * @var Closure
     */
    private $successClosure;

    /**
     * @var Closure|null
     */
    private $startProcessClosure;

    /**
     * @var Closure|null
     */
    private $finishProcessClosure;

    /**
     * @var Closure|null
     */
    private $advanceProcessClosure;

    public function __construct(
        ?Closure $error = null,
        ?Closure $warning = null,
        ?Closure $info = null,
        ?Closure $success = null,
        ?Closure $exception = null,
        ?Closure $startProcess = null,
        ?Closure $finishProcess = null,
        ?Closure $advanceProcess = null
    )
    {
        $this->errorClosure = $error ?? static function (string $message) {};
        $this->warningClosure = $warning ?? static function (string $message) {};
        $this->infoClosure = $info ?? static function (string $message) {};
        $this->successClosure = $success ?? static function (string $message) {};
        $this->exceptionClosure = $exception ?? function (Throwable $exception) { $this->error($exception->getMessage()); };
        $this->startProcessClosure = $startProcess ?? static function (int $total) {};
        $this->finishProcessClosure = $finishProcess ?? static function () {};
        $this->advanceProcessClosure = $advanceProcess ?? static function (int $steps) {};
    }

    public function exception(Throwable $exception): void
    {
        ($this->exceptionClosure)($exception);
    }

    public function error(string $message): void
    {
        ($this->errorClosure)($message);
    }

    public function warning(string $message): void
    {
        ($this->warningClosure)($message);
    }

    public function info(string $message): void
    {
        ($this->infoClosure)($message);
    }

    public function success(string $message): void
    {
        ($this->successClosure)($message);
    }

    public function startProcess(int $total = 0): void
    {
        ($this->startProcessClosure)($total);
    }

    public function finishProcess(): void
    {
        ($this->finishProcessClosure)();
    }

    public function advanceProcess(int $steps = 1): void
    {
        ($this->advanceProcessClosure)($steps);
    }
}
