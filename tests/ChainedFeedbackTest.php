<?php
declare(strict_types=1);

namespace Linku\Feedback\Tests;

use Linku\Feedback\ChainedFeedback;
use Linku\Feedback\Feedback;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use RuntimeException;

class ChainedFeedbackTest extends TestCase
{
    /**
     * @var Feedback|ObjectProphecy
     */
    private $firstFeedback;

    /**
     * @var Feedback|ObjectProphecy
     */
    private $secondFeedback;

    /**
     * @var ChainedFeedback
     */
    private $testSubject;

    protected function setUp(): void
    {
        $this->firstFeedback = $this->prophesize(Feedback::class);
        $this->secondFeedback = $this->prophesize(Feedback::class);

        $this->testSubject = new ChainedFeedback(
            $this->firstFeedback->reveal(),
            $this->secondFeedback->reveal()
        );
    }

    public function testException(): void
    {
        $exceptionMessage = 'Something went wrong!';
        $exception = new RuntimeException($exceptionMessage);

        $this->firstFeedback->exception($exception)
            ->shouldBeCalledOnce();
        $this->secondFeedback->exception($exception)
            ->shouldBeCalledOnce();

        $this->testSubject->exception($exception);
    }

    public function testError(): void
    {
        $message = 'Something went wrong!';

        $this->firstFeedback->error($message)
            ->shouldBeCalledOnce();
        $this->secondFeedback->error($message)
            ->shouldBeCalledOnce();

        $this->testSubject->error($message);
    }

    public function testWarning(): void
    {
        $message = 'Something went wrong!';

        $this->firstFeedback->warning($message)
            ->shouldBeCalledOnce();
        $this->secondFeedback->warning($message)
            ->shouldBeCalledOnce();

        $this->testSubject->warning($message);
    }

    public function testInfo(): void
    {
        $message = 'Something happened.';

        $this->firstFeedback->info($message)
            ->shouldBeCalledOnce();
        $this->secondFeedback->info($message)
            ->shouldBeCalledOnce();

        $this->testSubject->info($message);
    }

    public function testSuccess(): void
    {
        $message = 'Something went right!';

        $this->firstFeedback->success($message)
            ->shouldBeCalledOnce();
        $this->secondFeedback->success($message)
            ->shouldBeCalledOnce();

        $this->testSubject->success($message);
    }

    public function testStartProcess(): void
    {
        $defaultTotal = 0;

        $this->firstFeedback->startProcess($defaultTotal)
            ->shouldBeCalledOnce();
        $this->secondFeedback->startProcess($defaultTotal)
            ->shouldBeCalledOnce();

        $this->testSubject->startProcess();
    }

    public function testStartProcessWithTotal(): void
    {
        $total = 25;

        $this->firstFeedback->startProcess($total)
            ->shouldBeCalledOnce();
        $this->secondFeedback->startProcess($total)
            ->shouldBeCalledOnce();

        $this->testSubject->startProcess($total);
    }

    public function testFinishProcess(): void
    {
        $this->firstFeedback->finishProcess()
            ->shouldBeCalledOnce();
        $this->secondFeedback->finishProcess()
            ->shouldBeCalledOnce();

        $this->testSubject->finishProcess();
    }

    public function testAdvanceProcess(): void
    {
        $defaultSteps = 1;

        $this->firstFeedback->advanceProcess($defaultSteps)
            ->shouldBeCalledOnce();
        $this->secondFeedback->advanceProcess($defaultSteps)
            ->shouldBeCalledOnce();

        $this->testSubject->advanceProcess();
    }

    public function testAdvanceProcessWithSteps(): void
    {
        $steps = 5;

        $this->firstFeedback->advanceProcess($steps)
            ->shouldBeCalledOnce();
        $this->secondFeedback->advanceProcess($steps)
            ->shouldBeCalledOnce();

        $this->testSubject->advanceProcess($steps);
    }
}
