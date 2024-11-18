<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Root;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;

final class DefaultAction extends MultiLanguageAction implements DefaultActionInterface
{
    const DEFAULT_VIEW_NAME = 'root.page_name';

    public function __construct(
        protected readonly DynamicRootInterface $DynamicRootService,
        protected readonly TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        protected readonly DefaultViewDTOFactoryInterface $defaultViewDTOFactory
    ) {}

    public function execute(): string
    {
        $translatedMessage = $this->translateService->t($this::DEFAULT_VIEW_NAME);

        $dto = $this->defaultViewDTOFactory->create(
            $translatedMessage,
            $translatedMessage
        );

        $result = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return $result;
    }

    public function getDescription(): string
    {
        return $this->translateService->t($this::DEFAULT_VIEW_NAME);
    }
}
