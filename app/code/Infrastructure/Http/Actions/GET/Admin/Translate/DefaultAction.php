<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Translate;

use InvalidArgumentException;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Controller\Path;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Http\Views\ViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\AdminVisitor\AdminVisitorService;
use Romchik38\Site2\Application\Translate\List\Exceptions\CouldNotCountException;
use Romchik38\Site2\Application\Translate\List\Exceptions\CouldNotFilterException;
use Romchik38\Site2\Application\Translate\List\Filter;
use Romchik38\Site2\Application\Translate\List\ListService;
use Romchik38\Site2\Application\Translate\TranslateService\Delete;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Translate\DefaultAction\PaginationForm;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Translate\DefaultAction\ViewDto;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\CreatePagination;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\Query;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\UrlGeneratorUseUrlBuilder;

use function count;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public const SERVER_ERROR = 'server-error.message';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly ListService $translateList,
        private readonly LoggerInterface $logger,
        private readonly AdminVisitorService $adminVisitorService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $requestData = $request->getQueryParams();
        $command     = Filter::fromRequest($requestData);

        $uriRedirect = $this->urlbuilder->fromArray(['root', 'admin']);

        try {
            $filterResult = $this->translateList->list($command);
        } catch (InvalidArgumentException $e) {
            $this->adminVisitorService->changeMessage($e->getMessage());
            return new RedirectResponse($uriRedirect);
        } catch (CouldNotFilterException $e) {
            $this->logger->error($e->getMessage());
            $this->adminVisitorService->changeMessage($this->translateService->t($this::SERVER_ERROR));
            return new RedirectResponse($uriRedirect);
        }

        try {
            $totalCount = $this->translateList->totalCount();
        } catch (CouldNotCountException $e) {
            $this->logger->error($e->getMessage());
            $this->adminVisitorService->changeMessage($this->translateService->t($this::SERVER_ERROR));
            return new RedirectResponse($uriRedirect);
        }

        $searchCriteria = $filterResult->searchCriteria;
        $translateList  = $filterResult->list;
        $page           = $filterResult->page;

        $path              = new Path($this->getPath());
        $urlGenerator      = new UrlGeneratorUseUrlBuilder($path, $this->urlbuilder);
        $additionalQueries = [
            new Query(Filter::ORDER_BY_FIELD, ($searchCriteria->orderByField)()),
            new Query(Filter::ORDER_BY_DIRECTION_FIELD, ($searchCriteria->orderByDirection)()),
        ];
        $paginationView    = new CreatePagination(
            $urlGenerator,
            count($translateList),
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
            'Translates',
            'Translates page',
            $translateList,
            $paginationHtml,
            new PaginationForm(
                $searchCriteria->limit,
                $searchCriteria->orderByField,
                $searchCriteria->orderByDirection
            ),
            Delete::ID_FIELD,
            $visitor->getCsrfTokenField(),
            $visitor->getCsrfToken(),
        );

        $html = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return 'Translates list page';
    }
}
