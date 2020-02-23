<?php
declare(strict_types=1);

namespace Linku\Feedback\Tests;

use Linku\Feedback\NoFeedback;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class NoFeedbackTest extends TestCase
{
    public function testAll(): void
    {
        // Make sure nothing happens at all
        $this->expectOutputString('');

        $testSubject = new NoFeedback();

        $testSubject->exception(new RuntimeException('Something went wrong!'));
        $testSubject->error('Something went wrong!');
        $testSubject->warning('Something went wrong!');
        $testSubject->info('Something happened.');
        $testSubject->success('Something went right!');
        $testSubject->startProcess();
        $testSubject->advanceProcess();
        $testSubject->finishProcess();
    }
}
