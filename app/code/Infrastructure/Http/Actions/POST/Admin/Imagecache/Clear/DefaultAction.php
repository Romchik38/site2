<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Imagecache\Clear;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\AdminVisitor\AdminVisitorService;
use Romchik38\Site2\Application\ImageCache\ImageCacheService\Exceptions\RepositoryException;
use Romchik38\Site2\Application\ImageCache\ImageCacheService\ImageCacheService;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public const SUCCESS_MESSAGE_KEY = 'admin.image-cache.cache-cleared';
    public const ERROR_MESSAGE_KEY   = 'server-error.message';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly AdminVisitorService $adminVisitorService,
        private readonly ImageCacheService $imageCacheService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly LoggerInterface $logger,
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $this->imageCacheService->clear();
        } catch (RepositoryException $e) {
            $this->logger->error($e->getMessage());
            $uri = $this->urlbuilder->fromArray(['root', 'admin']);
            $this->adminVisitorService->changeMessage($this->translateService->t($this::ERROR_MESSAGE_KEY));
            return new RedirectResponse($uri);
        }

        $this->adminVisitorService->changeMessage($this->translateService->t($this::SUCCESS_MESSAGE_KEY));
        $uri = $this->urlbuilder->fromArray(['root', 'admin', 'imagecache']);
        return new RedirectResponse($uri);
    }

    public function getDescription(): string
    {
        return 'Admin Image Cache clear point';
    }
}
