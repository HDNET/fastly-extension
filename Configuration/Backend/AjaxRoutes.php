<?php

declare(strict_types=1);

use HDNET\CdnFastly\EventListener\FastlyClearCacheListener;

return [
    'fastly' => [
        'path' => '/backend/fastly',
        'target' => FastlyClearCacheListener::class . '::clear',
    ],
];
