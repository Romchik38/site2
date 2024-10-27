<?php

declare(strict_types=1);

namespace Romchik38\Site2\Controllers\Article;

use Romchik38\Server\Api\Controllers\Actions\DynamicActionInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;
use Romchik38\Server\Controllers\Errors\NotFoundException;

final class DynamicAction extends MultiLanguageAction implements DynamicActionInterface
{

    public function __construct(
        protected readonly DynamicRootInterface $DynamicRootService,
        protected readonly TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        /** @todo create Article DTO */
        protected readonly DefaultViewDTOFactoryInterface $defaultViewDTOFactory
    ) {}

    public function execute(string $dynamicRoute): string
    {

        /** 1 get article by dynamic route */
        $dto = $this->defaultViewDTOFactory->create(
            'Article page',
            'Article page description'
        );

        $result  = $this->view
            ->setController($this->getController(), 'index')
            ->setControllerData($dto)
            ->toString();

        return $result;
    }

    /** @todo return routes */
    public function getRoutes(): array
    {
        return [];
    }
}
