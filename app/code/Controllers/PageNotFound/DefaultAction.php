<?php

declare(strict_types=1);

namespace Romchik38\Site2\Controllers\PageNotFound;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;

final class DefaultAction extends MultiLanguageAction implements DefaultActionInterface {

    const DEFAULT_VIEW_NAME = 'Page not found (404)';
    const DEFAULT_VIEW_DESCRIPTION = 'Requested page was not found on our server';

    public function __construct(
        protected readonly DynamicRootInterface $DynamicRootService,
        protected readonly TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        protected readonly DefaultViewDTOFactoryInterface $defaultViewDTOFactory
    ) {}
    
    public function execute(): string
    {
        $dto = $this->defaultViewDTOFactory->create(
            $this::DEFAULT_VIEW_NAME,
            $this::DEFAULT_VIEW_DESCRIPTION
        );

        $result = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return $result;
    }
}
