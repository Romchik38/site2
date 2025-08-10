<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image;

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
use Romchik38\Server\Http\Views\Dto\Api\ApiDTO;
use Romchik38\Server\Http\Views\Dto\Api\ApiDTOInterface;
use Romchik38\Server\Http\Views\ViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\AdminVisitor\AdminVisitorService;
use Romchik38\Site2\Application\Image\AdminImageListService\AdminImageListService;
use Romchik38\Site2\Application\Image\AdminImageListService\Filter;
use Romchik38\Site2\Application\Image\ImageService\Delete;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image\DefaultAction\JsonViewDto;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image\DefaultAction\PaginationForm;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image\DefaultAction\ViewDto;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\CreatePagination;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\Query;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\UrlGeneratorUseUrlBuilder;

use function count;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    use RequestHandlerTrait;

    public const ACCEPTHEADER     = ['text/html', 'application/json'];
    public const JSON_NAME        = 'Images list api';
    public const JSON_DESCRIPTION = 'Uses to get filter result of existing images';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly AdminImageListService $adminImageListService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly AdminVisitorService $adminVisitorService
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

            $filterResult   = $this->adminImageListService->list($command);
            $searchCriteria = $filterResult->searchCriteria;
            $imagesList     = $filterResult->list;
            $page           = $filterResult->page;
            $totalCount     = $this->adminImageListService->totalCount();
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

        // JSON
        if ($responseType === 'application/json') {
            return new JsonResponse(new JsonViewDto(
                $this::JSON_NAME,
                $this::JSON_DESCRIPTION,
                ApiDTOInterface::STATUS_SUCCESS,
                $imagesList,
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
            count($imagesList),
            ($searchCriteria->limit)(),
            Filter::LIMIT_FIELD,
            ($page)(),
            Filter::PAGE_FIELD,
            $totalCount,
            $additionalQueries
        );

        $paginationHtml = $paginationView->create();

        $visitor = $this->adminVisitorService->getVisitor();

        $dto = new ViewDto(
            'Images',
            'Images page',
            $imagesList,
            $paginationHtml,
            new PaginationForm(
                $searchCriteria->limit,
                $searchCriteria->orderByField,
                $searchCriteria->orderByDirection
            ),
            $visitor->getCsrfTokenField(),
            $visitor->getCsrfToken(),
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
        return 'Images page';
    }
}
