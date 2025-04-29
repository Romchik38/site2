<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Root;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Services\Translate\TranslateInterface;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    private const DEFAULT_VIEW_NAME = 'root.page_name';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly DefaultViewDTOFactoryInterface $defaultViewDtoFactory
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(): ResponseInterface
    {
        $translatedMessage = $this->translateService->t($this::DEFAULT_VIEW_NAME);

        $dto = $this->defaultViewDtoFactory->create(
            $translatedMessage,
            $translatedMessage
        );

        $result = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($result);
    }

    public function getDescription(): string
    {
        return $this->translateService->t($this::DEFAULT_VIEW_NAME);
    }
}
