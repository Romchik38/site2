<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Author;

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
use Romchik38\Site2\Application\Author\AdminList\AdminAuthorList;
use Romchik38\Site2\Application\Author\AdminList\Filter;
use Romchik38\Site2\Application\Author\AuthorService\Delete;
use Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Author\DefaultAction\PaginationForm;
use Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Author\DefaultAction\ViewDto;
use Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface;
use Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface;
use Romchik38\Site2\Infrastructure\Views\Html\Classes\CreatePagination;
use Romchik38\Site2\Infrastructure\Views\Html\Classes\Pagination;

use function count;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly ServerRequestInterface $request,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly AdminAuthorList $adminAuthorList,
        private readonly Site2SessionInterface $session,
        private readonly CsrfTokenGeneratorInterface $csrfTokenGenerator,
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(): ResponseInterface
    {
        $requestData = $this->request->getQueryParams();
        $command     = Filter::fromRequest($requestData);

        $filterResult   = $this->adminAuthorList->list($command);
        $searchCriteria = $filterResult->searchCriteria;
        $authorList     = $filterResult->list;
        $page           = $filterResult->page;
        $totalCount     = $this->adminAuthorList->totalCount();

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
            count($authorList)
        );

        $paginationHtml = $paginationView->create();

        $csrfToken = $this->csrfTokenGenerator->asBase64();
        $this->session->setData($this->session::ADMIN_CSRF_TOKEN_FIELD, $csrfToken);

        $dto = new ViewDto(
            'Authors',
            'Authors page',
            $authorList,
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
        return 'Authors page';
    }
}
