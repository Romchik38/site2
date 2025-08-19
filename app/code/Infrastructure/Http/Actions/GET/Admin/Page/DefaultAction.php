<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Page;

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
use Romchik38\Site2\Application\Page\AdminList\AdminList;
use Romchik38\Site2\Application\Page\AdminList\Commands\Filter\Filter;
use Romchik38\Site2\Application\Page\PageService\Commands\Delete;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Page\DefaultAction\PaginationForm;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Page\DefaultAction\ViewDto;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\CreatePagination;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\Query;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\UrlGeneratorUseUrlBuilder;

use function count;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public const DESCRIPTION = 'Pages list';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ControllerViewInterface $view,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly AdminList $pageList
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $requestData = $request->getQueryParams();
        $command     = Filter::fromRequest($requestData);

        $filterResult = $this->pageList->filter($command, $this->getLanguage());

        $searchCriteria = $filterResult->searchCriteria;
        $pageList       = $filterResult->list;
        $page           = $filterResult->page;
        $totalCount     = $this->pageList->totalCount();

        $path              = new Path($this->getPath());
        $urlGenerator      = new UrlGeneratorUseUrlBuilder($path, $this->urlbuilder);
        $additionalQueries = [
            new Query(Filter::ORDER_BY_FIELD, ($searchCriteria->orderByField)()),
            new Query(Filter::ORDER_BY_DIRECTION_FIELD, ($searchCriteria->orderByDirection)()),
        ];
        $paginationView    = new CreatePagination(
            $urlGenerator,
            count($pageList),
            ($searchCriteria->limit)(),
            Filter::LIMIT_FIELD,
            ($page)(),
            Filter::PAGE_FIELD,
            $totalCount,
            $additionalQueries
        );

        $paginationHtml = $paginationView->create();

        $dto = new ViewDto(
            'Pages',
            self::DESCRIPTION,
            $pageList,
            $paginationHtml,
            new PaginationForm(
                $searchCriteria->limit,
                $searchCriteria->orderByField,
                $searchCriteria->orderByDirection
            ),
            Delete::ID_FIELD
        );

        $html = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return self::DESCRIPTION;
    }
}
