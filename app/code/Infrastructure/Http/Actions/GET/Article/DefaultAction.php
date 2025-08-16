<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Article;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Controller\Path;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Http\Views\ControllerViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Article\List\Commands\Filter\Filter;
use Romchik38\Site2\Application\Article\List\ListService;
use Romchik38\Site2\Application\Article\MostVisited\MostVisited;
use Romchik38\Site2\Application\Banner\List\Exceptions\NoBannerToDisplayException;
use Romchik38\Site2\Application\Banner\List\Exceptions\PriorityException;
use Romchik38\Site2\Application\Banner\List\ListService as BannerService;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Article\DefaultAction\ViewDTO;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\CreatePagination;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\Query;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\UrlGeneratorUseUrlBuilder;

use function count;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    private const PAGE_NAME_KEY        = 'article.page_name';
    private const PAGE_DESCRIPTION_KEY = 'article.description';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ControllerViewInterface $view,
        private readonly ListService $listService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly BannerService $bannerService,
        private readonly MostVisited $mostVisitedService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $requestData = $request->getQueryParams();

        $command        = Filter::fromRequest($requestData);
        $filterResult   = $this->listService->list($command, $this->getLanguage());
        $searchCriteria = $filterResult->searchCriteria;
        $articleList    = $filterResult->list;
        $page           = $filterResult->page;
        $totalCount     = $this->listService->listTotal();

        $path              = new Path($this->getPath());
        $urlGenerator      = new UrlGeneratorUseUrlBuilder($path, $this->urlbuilder);
        $additionalQueries = [
            new Query(Filter::ORDER_BY_FIELD, ($searchCriteria->orderByField)()),
            new Query(Filter::ORDER_BY_DIRECTION_FIELD, ($searchCriteria->orderByDirection)()),
        ];
        $paginationView    = new CreatePagination(
            $urlGenerator,
            count($articleList),
            ($searchCriteria->limit)(),
            Filter::LIMIT_FIELD,
            ($page)(),
            Filter::PAGE_FIELD,
            $totalCount,
            $additionalQueries
        );

        $translatedPageName        = $this->translateService->t($this::PAGE_NAME_KEY);
        $translatedPageDescription = $this->translateService->t($this::PAGE_DESCRIPTION_KEY);

        try {
            $banner = $this->bannerService->priority();
        } catch (PriorityException) {
            $banner = null;
        } catch (NoBannerToDisplayException) {
            $banner = null;
        }

        try {
            $mostVisited = $this->mostVisitedService->list(3, $this->getLanguage());
        } catch (PriorityException) {
            $mostVisited = [];
        } catch (NoBannerToDisplayException) {
            $mostVisited = [];
        }

        $dto = new ViewDTO(
            $translatedPageName,
            $translatedPageDescription,
            $articleList,
            $paginationView,
            $this->urlbuilder->fromPath($path),
            $banner,
            $this->translateService,
            $mostVisited
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
