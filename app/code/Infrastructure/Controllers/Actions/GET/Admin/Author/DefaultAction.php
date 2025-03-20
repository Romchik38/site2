<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Author;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO as ViewDto;

final class DefaultAction extends AbstractMultiLanguageAction
    implements DefaultActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        protected readonly ServerRequestInterface $request,
        protected readonly UrlbuilderInterface $urlbuilder
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(): ResponseInterface
    {
        $requestData = $this->request->getQueryParams();
        // $command     = Filter::fromRequest($requestData);

        // $filterResult   = $this->adminImageListService->list($command);
        // $searchCriteria = $filterResult->searchCriteria;
        // $imagesList     = $filterResult->list;
        // $page           = $filterResult->page;
        // $totalCount     = $this->adminImageListService->totalCount();

        // $path       = new Path($this->getPath());
        // $pagination = new Pagination(
        //     (string) ($searchCriteria->limit)(),
        //     (string) ($page)(),
        //     ($searchCriteria->orderByField)(),
        //     ($searchCriteria->orderByDirection)(),
        //     $totalCount
        // );

        // $paginationView = new CreatePagination(
        //     $path,
        //     $this->urlbuilder,
        //     $pagination,
        //     count($imagesList)
        // );

        // $paginationHtml = $paginationView->create();

        $dto = new ViewDto(
            'Authors',
            'Authors page',
            // $imagesList,
            // $paginationHtml,
            // new PaginationForm(
            //     $searchCriteria->limit,
            //     $searchCriteria->orderByField,
            //     $searchCriteria->orderByDirection
            // )
        );

        $html = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return 'Authors page';
    }
}