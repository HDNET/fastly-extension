<?php

namespace HDNET\CdnFastly\Tests\Unit\EventListener;

use HDNET\CdnFastly\EventListener\FastlyClearCacheListener;
use HDNET\CdnFastly\Tests\Unit\AbstractTestCase;

class FastlyClearCacheListenerTest extends AbstractTestCase
{
    public function testIsLoadable()
    {
        $object = new FastlyClearCacheListener();
        self::assertInstanceOf(FastlyClearCacheListener::class, $object, 'Object should be creatable');
    }
}
