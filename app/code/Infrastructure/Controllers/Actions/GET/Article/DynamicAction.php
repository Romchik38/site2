<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Article;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DynamicActionInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Controllers\Errors\ActionNotFoundException;
use Romchik38\Server\Controllers\Errors\DynamicActionLogicException;
use Romchik38\Server\Models\DTO\DynamicRoute\DynamicRouteDTO;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Services\Translate\TranslateInterface;
use Romchik38\Site2\Application\Article\ArticleView\ArticleViewService;
use Romchik38\Site2\Application\Article\ArticleView\Find;
use Romchik38\Site2\Application\Article\ArticleView\NoSuchArticleException;
use Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Article\DynamicAction\ViewDTO;

use function sprintf;

final class DynamicAction extends AbstractMultiLanguageAction implements DynamicActionInterface
{
    public function __construct(
        protected DynamicRootInterface $dynamicRootService,
        protected TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        protected readonly ArticleViewService $articleViewService
    ) {
    }

    public function execute(string $dynamicRoute): ResponseInterface
    {
        $decodedRoute = urldecode($dynamicRoute);
        try {
            $article = $this->articleViewService->getArticle(new Find(
                $decodedRoute,
                $this->getLanguage()
            ));
        } catch (NoSuchArticleException $e) {
            throw new ActionNotFoundException(
                sprintf('Route %s not found. Error message: %s', $dynamicRoute, $e->getMessage())
            );
        }

    /** we pass all checks and can send translate to view */

        $dto = new ViewDTO(
            $article->name,
            $article->shortDescription,
            $article
        );

        $result = $this->view
        ->setController($this->getController(), $dynamicRoute)
        ->setControllerData($dto)
        ->toString();

        return new HtmlResponse($result);
    }

    public function getDynamicRoutes(): array
    {
        $articles = $this->articleViewService->listIdsNames($this->getLanguage());
        $routes   = [];
        foreach ($articles as $article) {
            $routes[] = new DynamicRouteDTO($article->articleId, $article->name);
        }
        return $routes;
    }

    public function getDescription(string $dynamicRoute): string
    {
        try {
            return $this->articleViewService
            ->getArticleName(new Find(
                $dynamicRoute,
                $this->getLanguage()
            ));
        } catch (NoSuchArticleException $e) {
            throw new DynamicActionLogicException(
                sprintf(
                    'Description not found in action %s',
                    $dynamicRoute
                )
            );
        }
    }
}
