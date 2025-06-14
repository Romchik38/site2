<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Category;

use InvalidArgumentException;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DynamicActionInterface;
use Romchik38\Server\Http\Controller\Errors\ActionNotFoundException;
use Romchik38\Server\Http\Controller\Name;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Views\ViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Category\View\Commands\Filter\Filter;
use Romchik38\Site2\Application\Category\View\Exceptions\NoSuchCategoryException;
use Romchik38\Site2\Application\Category\View\ViewService;

use function sprintf;
use function urldecode;

final class DynamicAction extends AbstractMultiLanguageAction implements DynamicActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly ViewService $categoryService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $dynamicAttribute = $request->getAttribute(self::TYPE_DYNAMIC_ACTION);
        try {
            $dynamicRoute = new Name($dynamicAttribute);
            $decodedRoute = urldecode($dynamicRoute());
        } catch (InvalidArgumentException) {
            throw new ActionNotFoundException('action ' . $dynamicAttribute . ' not found');
        }

        $requestData = $request->getQueryParams();

        try {
            $findResult = $this->categoryService->find(
                Filter::fromRequest($requestData),
                $this->getLanguage(),
                $decodedRoute
            );
        } catch (NoSuchCategoryException $e) {
            throw new ActionNotFoundException(sprintf(
                'Category with id %s not found. Error message: %s',
                $decodedRoute,
                $e->getMessage()
            ));
        }

        // $dto = new ViewDTO(
        //     $article->name,
        //     $article->shortDescription,
        //     $article
        // );

        // $result = $this->view
        // ->setController($this->getController(), $decodedRoute)
        // ->setControllerData($dto)
        // ->toString();

        return new HtmlResponse('hello world');
    }

    /** @todo implement */
    public function getDynamicRoutes(): array
    {
        // $articles = $this->articleViewService->listIdsNames($this->getLanguage());
        // $routes   = [];
        // foreach ($articles as $article) {
        //     $routes[] = new DynamicRouteDTO($article->articleId, $article->name);
        // }
        // return $routes;
        return [];
    }

    /** @todo implement */
    public function getDescription(string $dynamicRoute): string
    {
        // try {
        //     return $this->articleViewService->getArticleName(new Find(
        //         $dynamicRoute,
        //         $this->getLanguage()
        //     ));
        // } catch (NoSuchArticleException) {
        //     throw new DynamicActionLogicException(sprintf(
        //         'Description not found in action %s',
        //         $dynamicRoute
        //     ));
        // }

        return $dynamicRoute . ' description';
    }
}
