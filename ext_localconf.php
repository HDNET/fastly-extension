<?php

use HDNET\CdnFastly\Cache\FastlyBackend;

defined('TYPO3') || die();

$boot = static function (): void {
    if (empty($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['CdnFastly'] ?? null)) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['CdnFastly'] = [
            'backend' => FastlyBackend::class,
            'groups' => [
                'fastly',
            ],
        ];
    }
};

$boot();
unset($boot);
