<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author;

use Exception;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\TextResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Controller\Actions\RequestHandlerTrait;
use Romchik38\Server\Http\Controller\Path;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Http\Views\ControllerViewInterface;
use Romchik38\Server\Http\Views\Dto\Api\ApiDTO;
use Romchik38\Server\Http\Views\Dto\Api\ApiDTOInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Author\AdminList\AdminAuthorList;
use Romchik38\Site2\Application\Author\AdminList\Filter;
use Romchik38\Site2\Application\Author\AuthorService\Commands\Delete;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author\DefaultAction\JsonViewDto;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author\DefaultAction\PaginationForm;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author\DefaultAction\ViewDto;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\CreatePagination;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\Query;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\UrlGeneratorUseUrlBuilder;

use function count;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    use RequestHandlerTrait;

    public const ACCEPTHEADER     = ['text/html', 'application/json'];
    public const JSON_NAME        = 'Authors list api';
    public const JSON_DESCRIPTION = 'Uses to get filter result of existing authors';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ControllerViewInterface $view,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly AdminAuthorList $adminAuthorList
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $responseType = $this->serializeAcceptHeader(
            $this::ACCEPTHEADER,
            $request->getHeaderLine('Accept')
        );

        if ($responseType === null) {
            $response = new TextResponse('The requested content type is not acceptable');
            return $response->withStatus(406);
        }

        try {
            $requestData = $request->getQueryParams();
            $command     = Filter::fromRequest($requestData);

            $filterResult   = $this->adminAuthorList->list($command);
            $searchCriteria = $filterResult->searchCriteria;
            $authorList     = $filterResult->list;
            $page           = $filterResult->page;
            $totalCount     = $this->adminAuthorList->totalCount();
        } catch (Exception $e) {
            if ($responseType === 'application/json') {
                return new JsonResponse(new ApiDTO(
                    $this::JSON_NAME,
                    $this::JSON_DESCRIPTION,
                    ApiDTOInterface::STATUS_ERROR,
                    'Error while execution request. Please try later.'
                ));
            } else {
                throw $e;
            }
        }

        if ($responseType === 'application/json') {
            return new JsonResponse(new JsonViewDto(
                $this::JSON_NAME,
                $this::JSON_DESCRIPTION,
                ApiDTOInterface::STATUS_SUCCESS,
                $authorList,
                $totalCount,
                ($searchCriteria->limit)(),
                Filter::LIMIT_FIELD,
                ($page)(),
                Filter::PAGE_FIELD,
                ($searchCriteria->orderByField)(),
                Filter::ORDER_BY_FIELD,
                ($searchCriteria->orderByDirection)(),
                Filter::ORDER_BY_DIRECTION_FIELD
            ));
        }

        // HTML
        $path              = new Path($this->getPath());
        $urlGenerator      = new UrlGeneratorUseUrlBuilder($path, $this->urlbuilder);
        $additionalQueries = [
            new Query(Filter::ORDER_BY_FIELD, ($searchCriteria->orderByField)()),
            new Query(Filter::ORDER_BY_DIRECTION_FIELD, ($searchCriteria->orderByDirection)()),
        ];
        $paginationView    = new CreatePagination(
            $urlGenerator,
            count($authorList),
            ($searchCriteria->limit)(),
            Filter::LIMIT_FIELD,
            ($page)(),
            Filter::PAGE_FIELD,
            $totalCount,
            $additionalQueries
        );

        $paginationHtml = $paginationView->create();

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
        return 'Authors page';
    }
}
