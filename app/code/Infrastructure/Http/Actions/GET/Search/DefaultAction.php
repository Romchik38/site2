<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Search;

use InvalidArgumentException;
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
use Romchik38\Site2\Application\Search\Article\ArticleSearchService;
use Romchik38\Site2\Application\Search\Article\Commands\List\ListCommand;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Search\DefaultAction\QueryMetaData;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Search\DefaultAction\ViewDTO;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\CreatePaginationNextPrev;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\Query;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\UrlGeneratorUseUrlBuilder;

use function count;
use function is_string;
use function urlencode;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    private const PAGE_NAME        = 'search.page_name';
    private const PAGE_DESCRIPTION = 'search.page_description';
    private const NEXT_LABEL       = 'button.next';
    private const PREV_LABEL       = 'button.prev';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ControllerViewInterface $view,
        private readonly ArticleSearchService $articleSearchService,
        private readonly UrlbuilderInterface $urlbuilder
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $requestData    = $request->getQueryParams();
        $query          = null;
        $rawQuery       = $requestData[ListCommand::QUERY_FILED] ?? null;
        $articleList    = [];
        $paginationHtml = '';
        if (is_string($rawQuery)) {
            $query = $rawQuery;
            $page  = $requestData[ListCommand::PAGE_FILED] ?? '';
            if (! is_string($page)) {
                $page = '';
            }
            $command = new ListCommand($query, $this->getLanguage(), $page);
            try {
                $listResult     = $this->articleSearchService->list($command);
                $searchResult   = $listResult->searchResult;
                $page           = $listResult->page;
                $totalCount     = $searchResult->totalCount;
                $articleList    = $searchResult->articles;
                $urlGenerator   = new UrlGeneratorUseUrlBuilder(
                    new Path(['root', 'search']),
                    $this->urlbuilder
                );
                $searchQuery    = new Query(ListCommand::QUERY_FILED, urlencode((string) $listResult->query));
                $pagination     = new CreatePaginationNextPrev(
                    $urlGenerator,
                    count($articleList),
                    $page(),
                    ListCommand::PAGE_FILED,
                    $totalCount(),
                    ($listResult->limit)(),
                    [$searchQuery],
                    $this->translateService->t($this::NEXT_LABEL),
                    $this->translateService->t($this::PREV_LABEL)
                );
                $paginationHtml = $pagination->create();
            } catch (InvalidArgumentException) {
                // do nothing
            }
        }

        $dto = new ViewDTO(
            $this->translateService->t($this::PAGE_NAME),
            $this->translateService->t($this::PAGE_DESCRIPTION),
            $articleList,
            $query,
            $this->translateService,
            $paginationHtml,
            new QueryMetaData()
        );

        $result = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($result);
    }

    public function getDescription(): string
    {
        return $this->translateService->t($this::PAGE_NAME);
    }
}
