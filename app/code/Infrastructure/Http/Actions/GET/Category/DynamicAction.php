<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Category;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DynamicActionInterface;
use Romchik38\Server\Http\Controller\Dto\DynamicRouteDTO;
use Romchik38\Server\Http\Controller\Errors\ActionNotFoundException;
use Romchik38\Server\Http\Controller\Errors\DynamicActionLogicException;
use Romchik38\Server\Http\Controller\Path;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Http\Views\ControllerViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Article\MostVisited\MostVisited;
use Romchik38\Site2\Application\Banner\List\Exceptions\NoBannerToDisplayException;
use Romchik38\Site2\Application\Banner\List\Exceptions\PriorityException;
use Romchik38\Site2\Application\Banner\List\ListService as BannerService;
use Romchik38\Site2\Application\Category\View\Commands\Filter\Filter;
use Romchik38\Site2\Application\Category\View\Exceptions\NoSuchCategoryException;
use Romchik38\Site2\Application\Category\View\ViewService;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Category\DynamicAction\PaginationForm;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Category\DynamicAction\ViewDTO;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\CreatePagination;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\Query;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\UrlGeneratorUseUrlBuilder;

use function count;
use function is_string;
use function sprintf;

final class DynamicAction extends AbstractMultiLanguageAction implements DynamicActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ControllerViewInterface $view,
        private readonly ViewService $categoryService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly BannerService $bannerService,
        private readonly MostVisited $mostVisitedService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $decodedRoute = $request->getAttribute(self::TYPE_DYNAMIC_ACTION);
        if (! is_string($decodedRoute)) {
            throw new DynamicActionLogicException('param decodedRoute is invalid');
        }

        $requestData = $request->getQueryParams();

        try {
            $findResult = $this->categoryService->find(
                Filter::fromRequest($requestData),
                $this->getLanguage(),
                $decodedRoute
            );
        } catch (NoSuchCategoryException $e) {
            throw new ActionNotFoundException(sprintf(
                'Category with id %s not found. Error message: %s',
                $decodedRoute,
                $e->getMessage()
            ));
        }

        $searchCriteria = $findResult->searchCriteria;
        $category       = $findResult->category;
        $page           = $findResult->page;
        $totalCount     = $category->totalCount;

        $path              = new Path(['root', 'category', $decodedRoute]);
        $urlGenerator      = new UrlGeneratorUseUrlBuilder($path, $this->urlbuilder);
        $additionalQueries = [
            new Query(Filter::ORDER_BY_FIELD, ($searchCriteria->orderByField)()),
            new Query(Filter::ORDER_BY_DIRECTION_FIELD, ($searchCriteria->orderByDirection)()),
        ];
        $paginationView    = new CreatePagination(
            $urlGenerator,
            count($category->articles),
            ($searchCriteria->limit)(),
            Filter::LIMIT_FIELD,
            ($page)(),
            Filter::PAGE_FIELD,
            $totalCount,
            $additionalQueries
        );

        $paginationForm = new PaginationForm(
            $searchCriteria->limit,
            $searchCriteria->orderByField,
            $searchCriteria->orderByDirection
        );

        $articlePageUrl = $this->urlbuilder->fromArray(['root', 'article']);

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
            $category->getName(),
            $category->getDescription(),
            $category,
            $paginationView,
            $paginationForm,
            $articlePageUrl,
            $banner,
            $this->translateService,
            $mostVisited
        );

        $result = $this->view
            ->setController($this->getController(), $decodedRoute)
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($result);
    }

    public function getDynamicRoutes(): array
    {
        $categories = $this->categoryService->listIdNames($this->getLanguage());
        $routes     = [];
        foreach ($categories as $category) {
            $routes[] = new DynamicRouteDTO($category->getId(), $category->getName());
        }
        return $routes;
    }

    public function getDescription(string $dynamicRoute): string
    {
        try {
            $name = $this->categoryService->findName($dynamicRoute, $this->getLanguage());
            return $name();
        } catch (NoSuchCategoryException) {
            throw new DynamicActionLogicException(sprintf(
                'Description not found in action %s',
                $dynamicRoute
            ));
        }
    }
}
