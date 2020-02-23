# Linku/Feedback

Feedback is an io abstraction that lets you decouple functional code and
business logic from (CLI) I/O.

## Installation

```
composer require linku/feedback
```

## Use

In the class or service you want to decouple, add a `Feedback` attribute
and make sure it is filled with an instance of `NoFeedback` by default.

In order to allow the code calling this service to override the default
feedback, add a `setFeedback` method.

In the logic of your service, you can now call the feedback methods.

```php
<?php

use Linku\Feedback\Feedback;
use Linku\Feedback\NoFeedback;

class MyService
{
    /**
     * @var Feedback
     */
    private $feedback;

    public function __construct()
    {
        $this->feedback = new NoFeedback();
    }

    public function setFeedback(Feedback $feedback): void
    {
        $this->feedback = $feedback;    
    }

    public function run(): void
    {
        $this->feedback->info('Starting my service run');

        $this->feedback->startProcess();

        for ($i = 0; $i < 100; $i++) {
            try {
                // Do something in a loop here
            } catch (\Throwable $exception) {
                $this->feedback->exception($exception);
            }

            $this->feedback->advanceProcess();
        }

        $this->feedback->finishProcess();

        $this->feedback->success('Completed my service run');
    }
}
```

In the script or CLI command that uses your service, set the apropriate
feedback.

```php
<?php

$service = new MyService();

$service->setFeedback(new LoggerFeedback(new Logger()));

$service->run();
```

## Available feedback
### NoFeedback
A safe fallback that doesn't output anything.

### ClosureFeedback
A feedback you can fill with your own anonymous functions.

### LoggerFeedback
A feedback that will write to any PSR-3 Logger.

### ChainedFeedback
A feedback that lets you use multiple feedbacks at the same time.
```php
<?php

$myService->setFeedback(new ChainedFeedback(
    new LoggerFeedback(new Logger()),
    new ClosureFeedback(/* ... */)
));
```

## Other feedback packages
### SymfonyStyleFeedback
If you use Symfony CLI, check out [Linku/SymfonyStyleFeedback](https://github.com/linkunijmegen/SymfonyStyleFeedback)
for integration with the Symfony Style component.
