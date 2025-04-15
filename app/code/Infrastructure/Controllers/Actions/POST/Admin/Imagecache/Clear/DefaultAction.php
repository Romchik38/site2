<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Imagecache\Clear;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Services\Translate\TranslateInterface;
use Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Application\ImageCache\ImageCacheService\ImageCacheService;
use Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public const SUCCESS_MESSAGE_KEY = 'admin.image-cache.cache-cleared';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        protected readonly Site2SessionInterface $session,
        protected readonly ImageCacheService $imageCacheService,
        protected readonly UrlbuilderInterface $urlbuilder
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(): ResponseInterface
    {
        $this->imageCacheService->clear();
        $this->session->setData(
            Site2SessionInterface::MESSAGE_FIELD,
            $this->translateService->t($this::SUCCESS_MESSAGE_KEY)
        );
        $uri = $this->urlbuilder->fromArray(['root', 'admin', 'imagecache']);
        return new RedirectResponse($uri);
    }

    public function getDescription(): string
    {
        return 'Admin Image Cache clear point';
    }
}
