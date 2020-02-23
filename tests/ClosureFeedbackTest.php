<?php
declare(strict_types=1);

namespace Linku\Feedback\Tests;

use Linku\Feedback\ClosureFeedback;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class ClosureFeedbackTest extends TestCase
{
    public function testWithoutAnyClosures(): void
    {
        // Make sure nothing happens at all
        $this->expectOutputString('');

        $testSubject = new ClosureFeedback();

        $testSubject->exception(new RuntimeException('Something went wrong!'));
        $testSubject->error('Something went wrong!');
        $testSubject->warning('Something went wrong!');
        $testSubject->info('Something happened.');
        $testSubject->success('Something went right!');
        $testSubject->startProcess();
        $testSubject->advanceProcess();
        $testSubject->finishProcess();
    }

    public function testException(): void
    {
        $timesCalled = 0;
        $exceptionMessage = 'Something went wrong!';
        $exception = new RuntimeException($exceptionMessage);

        $testSubject = new ClosureFeedback(
            null,
            null,
            null,
            null,
            static function (\Throwable $actualException) use (&$timesCalled, $exception) {
                $timesCalled++;
                static::assertEquals($exception, $actualException);
            }
        );

        $testSubject->exception($exception);

        static::assertEquals(1, $timesCalled);
    }

    public function testExceptionThroughError(): void
    {
        $timesCalled = 0;
        $exceptionMessage = 'Something went wrong!';
        $exception = new RuntimeException($exceptionMessage);

        $testSubject = new ClosureFeedback(
            static function (string $actualMessage) use (&$timesCalled, $exceptionMessage) {
                $timesCalled++;
                static::assertEquals($exceptionMessage, $actualMessage);
            }
        );

        $testSubject->exception($exception);

        static::assertEquals(1, $timesCalled);
    }

    public function testError(): void
    {
        $timesCalled = 0;
        $message = 'Something went wrong!';

        $testSubject = new ClosureFeedback(
            static function (string $actualMessage) use (&$timesCalled, $message) {
                $timesCalled++;
                static::assertEquals($message, $actualMessage);
            }
        );

        $testSubject->error($message);

        static::assertEquals(1, $timesCalled);
    }

    public function testWarning(): void
    {
        $timesCalled = 0;
        $message = 'Something went wrong!';

        $testSubject = new ClosureFeedback(
            null,
            static function (string $actualMessage) use (&$timesCalled, $message) {
                $timesCalled++;
                static::assertEquals($message, $actualMessage);
            }
        );

        $testSubject->warning($message);

        static::assertEquals(1, $timesCalled);
    }

    public function testInfo(): void
    {
        $timesCalled = 0;
        $message = 'Something happened.';

        $testSubject = new ClosureFeedback(
            null,
            null,
            static function (string $actualMessage) use (&$timesCalled, $message) {
                $timesCalled++;
                static::assertEquals($message, $actualMessage);
            }
        );

        $testSubject->info($message);

        static::assertEquals(1, $timesCalled);
    }

    public function testSuccess(): void
    {
        $timesCalled = 0;
        $message = 'Something went right!';

        $testSubject = new ClosureFeedback(
            null,
            null,
            null,
            static function (string $actualMessage) use (&$timesCalled, $message) {
                $timesCalled++;
                static::assertEquals($message, $actualMessage);
            }
        );

        $testSubject->success($message);

        static::assertEquals(1, $timesCalled);
    }

    public function testStartProcess(): void
    {
        $timesCalled = 0;
        $defaultTotal = 0;

        $testSubject = new ClosureFeedback(
            null,
            null,
            null,
            null,
            null,
            static function (int $actualTotal) use (&$timesCalled, $defaultTotal) {
                $timesCalled++;
                static::assertEquals($defaultTotal, $actualTotal);
            }
        );

        $testSubject->startProcess();

        static::assertEquals(1, $timesCalled);
    }

    public function testStartProcessWithTotal(): void
    {
        $timesCalled = 0;
        $total = 25;

        $testSubject = new ClosureFeedback(
            null,
            null,
            null,
            null,
            null,
            static function (int $actualTotal) use (&$timesCalled, $total) {
                $timesCalled++;
                static::assertEquals($total, $actualTotal);
            }
        );

        $testSubject->startProcess($total);

        static::assertEquals(1, $timesCalled);
    }

    public function testFinishProcess(): void
    {
        $timesCalled = 0;

        $testSubject = new ClosureFeedback(
            null,
            null,
            null,
            null,
            null,
            null,
            static function () use (&$timesCalled) {
                $timesCalled++;
            }
        );

        $testSubject->finishProcess();

        static::assertEquals(1, $timesCalled);
    }

    public function testAdvanceProcess(): void
    {
        $timesCalled = 0;
        $defaultSteps = 1;

        $testSubject = new ClosureFeedback(
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            static function (int $actualSteps) use (&$timesCalled, $defaultSteps) {
                $timesCalled++;
                static::assertEquals($defaultSteps, $actualSteps);
            }
        );

        $testSubject->advanceProcess();

        static::assertEquals(1, $timesCalled);
    }

    public function testAdvanceProcessWithSteps(): void
    {
        $timesCalled = 0;
        $steps = 5;

        $testSubject = new ClosureFeedback(
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            static function (int $actualSteps) use (&$timesCalled, $steps) {
                $timesCalled++;
                static::assertEquals($steps, $actualSteps);
            }
        );

        $testSubject->advanceProcess($steps);

        static::assertEquals(1, $timesCalled);
    }
}
