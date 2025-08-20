<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Imagecache;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Http\Views\ControllerViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\AdminVisitor\AdminVisitorService;
use Romchik38\Site2\Application\ImageCache\ImageCacheService\Exceptions\RepositoryException;
use Romchik38\Site2\Application\ImageCache\ImageCacheService\ImageCacheService;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Imagecache\DefaultAction\ViewDto;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public const ERROR_MESSAGE_KEY = 'server-error.message';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ControllerViewInterface $view,
        private readonly ImageCacheService $imageCacheService,
        private readonly LoggerInterface $logger,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly AdminVisitorService $adminVisitorService,
        private readonly int $maxCacheSize
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $totalPrettySize = $this->imageCacheService->totalPrettySize();
            $totalCount      = $this->imageCacheService->totalCount();
            $totalSize       = $this->imageCacheService->totalSize();
        } catch (RepositoryException $e) {
            $this->logger->error($e->getMessage());
            $uri = $this->urlbuilder->fromArray(['root', 'admin']);
            $this->adminVisitorService->changeMessage($this->translateService->t($this::ERROR_MESSAGE_KEY));
            return new RedirectResponse($uri);
        }

        $dto = new ViewDto(
            'Image cache',
            'Image cache page',
            $totalCount,
            $totalPrettySize,
            $totalSize,
            $this->maxCacheSize
        );

        $html = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();
        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return 'Image cache page';
    }
}
