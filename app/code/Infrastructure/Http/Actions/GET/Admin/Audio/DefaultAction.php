<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio;

use InvalidArgumentException;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\Response\TextResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
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
use Romchik38\Site2\Application\AdminVisitor\AdminVisitorService;
use Romchik38\Site2\Application\Audio\AdminList\AdminList;
use Romchik38\Site2\Application\Audio\AdminList\CouldNotListException;
use Romchik38\Site2\Application\Audio\AdminList\Filter;
use Romchik38\Site2\Application\Audio\AudioService\Delete;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\DefaultAction\JsonViewDto;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\DefaultAction\PaginationForm;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\DefaultAction\ViewDto;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\CreatePagination;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\Query;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\UrlGeneratorUseUrlBuilder;

use function count;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    use RequestHandlerTrait;

    public const ACCEPTHEADER     = ['text/html', 'application/json'];
    public const JSON_NAME        = 'Audio list api';
    public const JSON_DESCRIPTION = 'Uses to get filter result of existing audio tracks';

    public const ERROR_MESSAGE_KEY = 'server-error.message';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ControllerViewInterface $view,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly AdminList $audioList,
        private readonly LoggerInterface $logger,
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

        $requestData        = $request->getQueryParams();
        $command            = Filter::fromRequest($requestData);
        $serverErrorMessage = $this->translateService->t($this::ERROR_MESSAGE_KEY);

        try {
            $filterResult = $this->audioList->list($command);
        } catch (CouldNotListException $e) {
            $this->logger->error($e->getMessage());
            if ($responseType === 'application/json') {
                return new JsonResponse(new ApiDTO(
                    $this::JSON_NAME,
                    $this::JSON_DESCRIPTION,
                    ApiDTOInterface::STATUS_ERROR,
                    'Error while execution request. Please try later.'
                ));
            } else {
                $uri = $this->urlbuilder->fromArray(['root', 'admin']);
                $this->adminVisitorService->changeMessage($serverErrorMessage);
                return new RedirectResponse($uri);
            }
        } catch (InvalidArgumentException $e) {
            $this->logger->error($e->getMessage());
            if ($responseType === 'application/json') {
                return new JsonResponse(new ApiDTO(
                    $this::JSON_NAME,
                    $this::JSON_DESCRIPTION,
                    ApiDTOInterface::STATUS_ERROR,
                    $e->getMessage()
                ));
            } else {
                $uri = $this->urlbuilder->fromArray(['root', 'admin']);
                $this->adminVisitorService->changeMessage($serverErrorMessage);
                return new RedirectResponse($uri);
            }
        }

        $searchCriteria = $filterResult->searchCriteria;
        $audioList      = $filterResult->list;
        $page           = $filterResult->page;
        $totalCount     = $this->audioList->totalCount();

        // JSON
        if ($responseType === 'application/json') {
            return new JsonResponse(new JsonViewDto(
                $this::JSON_NAME,
                $this::JSON_DESCRIPTION,
                ApiDTOInterface::STATUS_SUCCESS,
                $audioList,
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

        $paginationView = new CreatePagination(
            $urlGenerator,
            count($audioList),
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
            'Audios',
            'Audio list page',
            $audioList,
            $paginationHtml,
            new PaginationForm(
                $searchCriteria->limit,
                $searchCriteria->orderByField,
                $searchCriteria->orderByDirection
            ),
            Delete::ID_FIELD,
            $visitor->getCsrfTokenField(),
            $visitor->getCsrfToken()
        );

        $html = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return 'Audio list page';
    }
}
