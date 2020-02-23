<?php
declare(strict_types=1);

namespace Linku\Feedback\Tests;

use Linku\Feedback\LoggerFeedback;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Log\LoggerInterface;
use RuntimeException;

final class LoggerFeedbackTest extends TestCase
{
    /**
     * @var ObjectProphecy|LoggerInterface
     */
    private $logger;

    /**
     * @var LoggerFeedback
     */
    private $testSubject;

    protected function setUp(): void
    {
        $this->logger = $this->prophesize(LoggerInterface::class);

        $this->testSubject = new LoggerFeedback(
            $this->logger->reveal()
        );
    }

    public function testException(): void
    {
        $exceptionMessage = 'Something went wrong!';
        $exception = new RuntimeException($exceptionMessage);

        $this->logger->error($exceptionMessage)
            ->shouldBeCalledOnce();

        $this->testSubject->exception($exception);
    }

    public function testError(): void
    {
        $message = 'Something went wrong!';

        $this->logger->error($message)
            ->shouldBeCalledOnce();

        $this->testSubject->error($message);
    }

    public function testWarning(): void
    {
        $message = 'Something went wrong!';

        $this->logger->warning($message)
            ->shouldBeCalledOnce();

        $this->testSubject->warning($message);
    }

    public function testInfo(): void
    {
        $message = 'Something happened.';

        $this->logger->info($message)
            ->shouldBeCalledOnce();

        $this->testSubject->info($message);
    }

    public function testSuccess(): void
    {
        $message = 'Something went right!';

        $this->logger->info($message)
            ->shouldBeCalledOnce();

        $this->testSubject->success($message);
    }

    public function testStartProcess(): void
    {
        $message = 'Process started';

        $this->logger->info($message)
            ->shouldBeCalledOnce();

        $this->testSubject->startProcess();
    }

    public function testStartProcessWithTotal(): void
    {
        $total = 25;
        $message = 'Process of 25 started';

        $this->logger->info($message)
            ->shouldBeCalledOnce();

        $this->testSubject->startProcess($total);
    }

    public function testFinishProcess(): void
    {
        $message = 'Process stopped';

        $this->logger->info($message)
            ->shouldBeCalledOnce();

        $this->testSubject->finishProcess();
    }

    public function testAdvanceProcess(): void
    {
        $message = 'Process advanced with 1';

        $this->logger->debug($message)
            ->shouldBeCalledOnce();

        $this->testSubject->advanceProcess();
    }

    public function testAdvanceProcessWithSteps(): void
    {
        $steps = 5;
        $message = 'Process advanced with 5';

        $this->logger->debug($message)
            ->shouldBeCalledOnce();

        $this->testSubject->advanceProcess($steps);
    }
}
