<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article;

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
use Romchik38\Server\Http\Views\ControllerViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\AdminVisitor\AdminVisitorService;
use Romchik38\Site2\Application\Article\AdminList\AdminListService;
use Romchik38\Site2\Application\Article\AdminList\Commands\Filter\Filter;
use Romchik38\Site2\Application\Article\AdminList\Exceptions\CouldNotListException;
use Romchik38\Site2\Application\Article\ArticleService\Commands\Delete;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\DefaultAction\PaginationForm;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\DefaultAction\ViewDto;
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
        private readonly ControllerViewInterface $view,
        private readonly AdminListService $articleService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly LoggerInterface $logger,
        private readonly AdminVisitorService $adminVisitorService,
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $requestData = $request->getQueryParams();
        $command     = Filter::fromRequest($requestData);

        $uriRedirect = $this->urlbuilder->fromArray(['root', 'admin']);

        // List
        try {
            $filterResult = $this->articleService->list($command);
        } catch (CouldNotListException $e) {
            $this->logger->error($e->getMessage());
            $this->adminVisitorService->changeMessage($this->translateService->t($this::SERVER_ERROR));
            return new RedirectResponse($uriRedirect);
        } catch (InvalidArgumentException $e) {
            $this->logger->error($e->getMessage());
            $this->adminVisitorService->changeMessage($this->translateService->t($this::SERVER_ERROR));
            return new RedirectResponse($uriRedirect);
        }

        $searchCriteria = $filterResult->searchCriteria;
        $articleList    = $filterResult->list;
        $page           = $filterResult->page;
        $totalCount     = $this->articleService->totalCount();

        $path              = new Path($this->getPath());
        $urlGenerator      = new UrlGeneratorUseUrlBuilder($path, $this->urlbuilder);
        $additionalQueries = [
            new Query(Filter::ORDER_BY_FIELD, ($searchCriteria->orderByField)()),
            new Query(Filter::ORDER_BY_DIRECTION_FIELD, ($searchCriteria->orderByDirection)()),
        ];

        $paginationView = new CreatePagination(
            $urlGenerator,
            count($articleList),
            ($searchCriteria->limit)(),
            Filter::LIMIT_FIELD,
            ($page)(),
            Filter::PAGE_FIELD,
            $totalCount,
            $additionalQueries
        );

        $paginationHtml = $paginationView->create();

        $dto  = new ViewDto(
            'Admin article',
            'Admin article page',
            $articleList,
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
        return 'Admin article';
    }
}
