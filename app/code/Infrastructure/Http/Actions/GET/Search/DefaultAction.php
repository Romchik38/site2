<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Search;

use InvalidArgumentException;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Views\ViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Search\Article\ArticleSearchService;
use Romchik38\Site2\Application\Search\Article\Commands\List\ListCommand;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Search\DefaultAction\ViewDTO;

use function is_string;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    private const PAGE_NAME        = 'search.page_name';
    private const PAGE_DESCRIPTION = 'search.page_description';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly ArticleSearchService $articleSearchService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $requestData = $request->getQueryParams();
        $query       = null;
        $rawQuery    = $requestData[ListCommand::QUERY_FILED] ?? null;
        $articleList = [];
        if (is_string($rawQuery)) {
            $query   = $rawQuery;
            $command = new ListCommand($query, $this->getLanguage());
            try {
                $articleList = $this->articleSearchService->list($command);
            } catch (InvalidArgumentException) {
                // do nothing
            }
        }

        $dto = new ViewDTO(
            $this->translateService->t($this::PAGE_NAME),
            $this->translateService->t($this::PAGE_DESCRIPTION),
            $articleList,
            $query
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
