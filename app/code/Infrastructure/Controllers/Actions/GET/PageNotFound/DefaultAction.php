<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\PageNotFound;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface;
use Romchik38\Server\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public const DEFAULT_VIEW_NAME        = '404.page_name';
    public const DEFAULT_VIEW_DESCRIPTION = '404.description';

    public function __construct(
        protected DynamicRootInterface $dynamicRootService,
        protected TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        protected readonly DefaultViewDTOFactoryInterface $defaultViewDtoFactory
    ) {
    }

    public function execute(): ResponseInterface
    {
        $dto = $this->defaultViewDtoFactory->create(
            $this->translateService->t($this::DEFAULT_VIEW_NAME),
            $this->translateService->t($this::DEFAULT_VIEW_DESCRIPTION)
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
