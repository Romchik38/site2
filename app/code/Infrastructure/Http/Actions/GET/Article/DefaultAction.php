<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Article;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Controllers\Path;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Services\Translate\TranslateInterface;
use Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Application\Article\List\Commands\Pagination\Filter;
use Romchik38\Site2\Application\Article\List\ListService;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Article\DefaultAction\ViewDTO;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\CreatePagination;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\Pagination;

use function count;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    private const PAGE_NAME_KEY        = 'article.page_name';
    private const PAGE_DESCRIPTION_KEY = 'article.description';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly ListService $listService,
        private readonly ServerRequestInterface $request,
        private readonly UrlbuilderInterface $urlbuilder,
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(): ResponseInterface
    {
        $requestData = $this->request->getQueryParams();

        $command        = Filter::fromRequest($requestData);
        $filterResult   = $this->listService->list($command, $this->getLanguage());
        $searchCriteria = $filterResult->searchCriteria;
        $articleList    = $filterResult->list;
        $page           = $filterResult->page;
        $totalCount     = $this->listService->listTotal();

        $path       = new Path($this->getPath());
        $pagination = new Pagination(
            (string) ($searchCriteria->limit)(),
            (string) ($page)(),
            ($searchCriteria->orderByField)(),
            ($searchCriteria->orderByDirection)(),
            $totalCount
        );

        $paginationView = new CreatePagination(
            $path,
            $this->urlbuilder,
            $pagination,
            count($articleList)
        );

        $translatedPageName        = $this->translateService->t($this::PAGE_NAME_KEY);
        $translatedPageDescription = $this->translateService->t($this::PAGE_DESCRIPTION_KEY);

        $dto = new ViewDTO(
            $translatedPageName,
            $translatedPageDescription,
            $articleList,
            $paginationView,
            $this->urlbuilder->fromPath($path)
        );

        $result = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($result);
    }

    public function getDescription(): string
    {
        return $this->translateService->t($this::PAGE_NAME_KEY);
    }
}
