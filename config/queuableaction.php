<?php

declare(strict_types=1);

// Compliant with [.ai/AI-GUIDELINES.md](../../.ai/AI-GUIDELINES.md) v374a22e55a53ea38928957463e1f0ef28f820080a27e0466f35d46c20626fa72

use Spatie\QueueableAction\ActionJob;

return [
    /*
     * The job class that will be dispatched.
     * If you would like to change it and use your own job class,
     * it must extend the \Spatie\QueueableAction\ActionJob class.
     */
    'job_class' => ActionJob::class,
];
