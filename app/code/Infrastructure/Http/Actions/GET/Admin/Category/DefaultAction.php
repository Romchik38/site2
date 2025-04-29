<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Category;

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
use Romchik38\Site2\Application\Category\AdminList\AdminList;
use Romchik38\Site2\Application\Category\AdminList\Filter;
use Romchik38\Site2\Application\Category\CategoryService\Commands\Delete;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Category\DefaultAction\PaginationForm;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Category\DefaultAction\ViewDto;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\CreatePagination2;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\Pagination2;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\Query;
use Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface;

use function count;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly ServerRequestInterface $request,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly AdminList $categoryList,
        private readonly Site2SessionInterface $session,
        private readonly CsrfTokenGeneratorInterface $csrfTokenGenerator,
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(): ResponseInterface
    {
        $requestData = $this->request->getQueryParams();
        $command     = Filter::fromRequest($requestData);

        $filterResult = $this->categoryList->list($command);

        $searchCriteria = $filterResult->searchCriteria;
        $categoryList   = $filterResult->list;
        $page           = $filterResult->page;
        $totalCount     = $this->categoryList->totalCount();

        $path = new Path($this->getPath());

        /** @todo replace name 2 */
        $pagination = new Pagination2(
            /** @todo implement limit 0 (all) in actions */
            ($searchCriteria->limit)(),
            Filter::LIMIT_FIELD,
            ($page)(),
            Filter::PAGE_FIELD,
            $totalCount,
            [
                new Query(Filter::ORDER_BY_FIELD, ($searchCriteria->orderByField)()),
                new Query(Filter::ORDER_BY_DIRECTION_FIELD, ($searchCriteria->orderByDirection)()),
            ]
        );

        $paginationView = new CreatePagination2(
            $path,
            $this->urlbuilder,
            $pagination,
            count($categoryList)
        );

        $paginationHtml = $paginationView->create();

        $csrfToken = $this->csrfTokenGenerator->asBase64();
        $this->session->setData($this->session::ADMIN_CSRF_TOKEN_FIELD, $csrfToken);

        $dto = new ViewDto(
            'Categories',
            'Categories list page',
            $categoryList,
            $paginationHtml,
            new PaginationForm(
                $searchCriteria->limit,
                $searchCriteria->orderByField,
                $searchCriteria->orderByDirection
            ),
            Delete::ID_FIELD,
            $this->session::ADMIN_CSRF_TOKEN_FIELD,
            $csrfToken,
        );

        $html = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return 'Category list page';
    }
}
