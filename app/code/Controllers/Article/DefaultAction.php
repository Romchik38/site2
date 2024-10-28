<?php

declare(strict_types=1);

namespace Romchik38\Site2\Controllers\Article;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Models\Virtual\Article\Sql\ArticleRepository;

final class DefaultAction extends MultiLanguageAction implements DefaultActionInterface
{
    protected const PAGE_NAME_KEY = 'article.page_name';
    protected const PAGE_DESCRIPTION_KEY = 'article.description';

    public function __construct(
        protected readonly DynamicRootInterface $DynamicRootService,
        protected readonly TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        /** @todo create Article DTO */
        protected readonly DefaultViewDTOFactoryInterface $defaultViewDTOFactory,
        /** @todo replace with interface */
        protected readonly ArticleRepository $articleRepository
    ) {}

    public function execute(): string
    {
        try {
            $result = $this->articleRepository->getById('article-2');
        } catch (NoSuchEntityException $e) {
            // do something
        }

        $translatedPageName = $this->translateService->t($this::PAGE_NAME_KEY);
        $translatedPageDescription = $this->translateService->t($this::PAGE_DESCRIPTION_KEY);

        $dto = $this->defaultViewDTOFactory->create(
            $translatedPageName,
            $translatedPageDescription
        );

        $result = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return $result;
    }
}
