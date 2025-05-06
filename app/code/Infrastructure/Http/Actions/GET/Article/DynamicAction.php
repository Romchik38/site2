<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Article;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Http\Controller\Actions\DynamicActionInterface;
use Romchik38\Server\Http\Views\ViewInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Errors\ActionNotFoundException;
use Romchik38\Server\Controllers\Errors\DynamicActionLogicException;
use Romchik38\Server\Http\Controller\Dto\DynamicRouteDTO;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Article\View\Find;
use Romchik38\Site2\Application\Article\View\NoSuchArticleException;
use Romchik38\Site2\Application\Article\View\ViewService;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Article\DynamicAction\ViewDTO;

use function sprintf;
use function urldecode;

final class DynamicAction extends AbstractMultiLanguageAction implements DynamicActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly ViewService $articleViewService
    ) {
        parent::__construct($dynamicRootService, $translateService);
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
