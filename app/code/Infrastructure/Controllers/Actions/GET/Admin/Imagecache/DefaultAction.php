<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Imagecache;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Site2\Application\ImageCache\ImageCacheService;
use Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Imagecache\DefaultAction\ViewDto;

final class DefaultAction extends AbstractMultiLanguageAction
    implements DefaultActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        protected readonly ImageCacheService $imageCacheService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(): ResponseInterface
    {
        $totalPrettySize = $this->imageCacheService->totalPrettySize();
        $dto = new ViewDto(
            'Image cache', 
            'Image cache page',
            $this->imageCacheService->totalCount(),
            $totalPrettySize
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