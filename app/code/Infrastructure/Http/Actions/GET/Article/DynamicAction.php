<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Article;

use InvalidArgumentException;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DynamicActionInterface;
use Romchik38\Server\Http\Controller\Dto\DynamicRouteDTO;
use Romchik38\Server\Http\Controller\Errors\ActionNotFoundException;
use Romchik38\Server\Http\Controller\Errors\DynamicActionLogicException;
use Romchik38\Server\Http\Controller\Name;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Views\ViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Article\ArticleService\Commands\IncrementViews;
use Romchik38\Site2\Application\Article\ContinueReading\Commands\Update\Update;
use Romchik38\Site2\Application\Article\SimilarArticles\Commands\ListSimilar\ListSimilar;
use Romchik38\Site2\Application\Article\SimilarArticles\SimilarArticles;
use Romchik38\Site2\Application\Article\View\Find;
use Romchik38\Site2\Application\Article\View\NoSuchArticleException;
use Romchik38\Site2\Application\Article\View\ViewService;
use Romchik38\Site2\Application\Visitor\RepositoryException as VisitorRepositoryException;
use Romchik38\Site2\Application\Visitor\VisitorService;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Article\DynamicAction\ViewDTO;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface;

use function sprintf;
use function urldecode;

final class DynamicAction extends AbstractMultiLanguageAction implements DynamicActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly ViewService $articleViewService,
        private readonly Site2SessionInterface $session,
        private readonly CsrfTokenGeneratorInterface $csrfTokenGenerator,
        private readonly SimilarArticles $similarArticles,
        private readonly VisitorService $visitorService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $dynamicAttribute = $request->getAttribute(self::TYPE_DYNAMIC_ACTION);
        try {
            $dynamicRoute = new Name($dynamicAttribute);
        } catch (InvalidArgumentException) {
            throw new ActionNotFoundException('action ' . $dynamicAttribute . ' not found');
        }
        $decodedRoute = urldecode($dynamicRoute());

        // Article
        try {
            $article = $this->articleViewService->getArticle(new Find(
                $decodedRoute,
                $this->getLanguage()
            ));
        } catch (NoSuchArticleException $e) {
            throw new ActionNotFoundException(
                sprintf('Route %s not found. Error message: %s', $dynamicRoute(), $e->getMessage())
            );
        }

        // Similar
        $categories = [];
        foreach ($article->categories as $category) {
            $categories[] = (string) $category->id;
        }
        $similarCommand = new ListSimilar(
            $article->articleId,
            $categories,
            $this->getLanguage(),
            3
        );

        $similarArticles = $this->similarArticles->list($similarCommand);

        // Visitor
        try {
            $visitor   = $this->visitorService->getVisitor();
            $csrfToken = $visitor->getCsrfToken();
        } catch (VisitorRepositoryException $e) {
            $csrfToken = ''; // do nothing, block continue reading will not be shown
        }

        $dto = new ViewDTO(
            $article->name,
            $article->shortDescription,
            $article,
            $this->translateService,
            IncrementViews::ID_FIELD,
            $visitor::CSRF_TOKEN_FIELD,
            $csrfToken,
            $similarArticles,
            Update::ID_FIELD
        );

        $result = $this->view
        ->setController($this->getController(), $decodedRoute)
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
            return $this->articleViewService->getArticleName(new Find(
                $dynamicRoute,
                $this->getLanguage()
            ));
        } catch (NoSuchArticleException) {
            throw new DynamicActionLogicException(sprintf(
                'Description not found in action %s',
                $dynamicRoute
            ));
        }
    }
}
