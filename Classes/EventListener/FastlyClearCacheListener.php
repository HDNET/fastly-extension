<?php

declare(strict_types=1);

namespace HDNET\CdnFastly\EventListener;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Backend\Event\ModifyClearCacheActionsEvent;
use TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class FastlyClearCacheListener
{
    public function __invoke(ModifyClearCacheActionsEvent $event): void
    {
        $isAdmin = $GLOBALS['BE_USER']->isAdmin();
        $userTsConfig = $GLOBALS['BE_USER']->getTSConfig();
        if (!($isAdmin || (($userTsConfig['options.']['clearCache.'] ?? false) && ($userTsConfig['options.']['clearCache.']['fastly'] ?? false)))) {
            return;
        }

        $route = $this->getAjaxUri();
        if (!$route) {
            return;
        }

        $event->addCacheAction([
            'id' => 'cdn_fastly',
            'title' => 'LLL:EXT:cdn_fastly/Resources/Private/Language/locallang.xlf:cache.title',
            'description' => 'LLL:EXT:cdn_fastly/Resources/Private/Language/locallang.xlf:cache.description',
            'href' => $route,
            'iconIdentifier' => 'extension-cdn_fastly-clearcache',
        ]);
    }

    protected function getAjaxUri(): string
    {
        /** @var UriBuilder $uriBuilder */
        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        try {
            $routeIdentifier = 'ajax_fastly';
            $uri = $uriBuilder->buildUriFromRoute($routeIdentifier);
        } catch (RouteNotFoundException $e) {
            return '';
        }

        return (string)$uri;
    }

    public function clear(): ResponseInterface
    {
        $cacheManager = GeneralUtility::makeInstance(CacheManager::class);
        $cacheManager->flushCachesInGroup('fastly');

        return new HtmlResponse('');
    }
}
