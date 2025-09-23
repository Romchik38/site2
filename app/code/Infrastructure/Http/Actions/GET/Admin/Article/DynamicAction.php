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
use Romchik38\Server\Http\Controller\Actions\DynamicActionInterface;
use Romchik38\Server\Http\Controller\Errors\ActionNotFoundException;
use Romchik38\Server\Http\Controller\Name;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Http\Views\ControllerViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\AdminVisitor\AdminVisitorService;
use Romchik38\Site2\Application\Article\AdminView\AdminView;
use Romchik38\Site2\Application\Article\AdminView\CouldNotFindException;
use Romchik38\Site2\Application\Article\AdminView\NoSuchArticleException;
use Romchik38\Site2\Application\Article\ArticleService\Commands\Update;
use Romchik38\Site2\Application\Category\AdminList\AdminList;
use Romchik38\Site2\Application\Language\List\ListService;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\DynamicAction\AudioFiltersDto;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\DynamicAction\AuthorFiltersDto;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\DynamicAction\ImageFiltersDto;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\DynamicAction\ViewDto;

use function sprintf;

final class DynamicAction extends AbstractMultiLanguageAction implements DynamicActionInterface
{
    public const ERROR_MESSAGE_KEY = 'server-error.message';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ControllerViewInterface $view,
        private readonly ListService $languageService,
        private readonly AdminView $articleViewService,
        private readonly LoggerInterface $logger,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly string $audioPathPrefix,
        private readonly AdminList $categoryService,
        private readonly AdminVisitorService $adminVisitorService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $dynamicRoute = new Name($request->getAttribute(self::TYPE_DYNAMIC_ACTION));
        $decodedRoute = $request->getAttribute(self::TYPE_DYNAMIC_ACTION);

        $uriList = $this->urlbuilder->fromArray(['root', 'admin', 'article']);

        try {
            $id         = new ArticleId($decodedRoute);
            $articleDto = $this->articleViewService->find($id);
        } catch (NoSuchArticleException $e) {
            throw new ActionNotFoundException('Article with id %s not exist');
        } catch (InvalidArgumentException $e) {
            $this->adminVisitorService->changeMessage($this->translateService->t($this::ERROR_MESSAGE_KEY));
            return new RedirectResponse($uriList);
        } catch (CouldNotFindException $e) {
            $this->logger->error($e->getMessage());
            $this->adminVisitorService->changeMessage($this->translateService->t($this::ERROR_MESSAGE_KEY));
            return new RedirectResponse($uriList);
        }

        $languages  = $this->languageService->getAll();
        $categories = $this->categoryService->listAll();

        $dto = new ViewDto(
            sprintf('Article view id %s', $decodedRoute),
            sprintf('Article view page with id %s', $decodedRoute),
            $languages,
            $articleDto,
            Update::ID_FIELD,
            Update::CHANGE_ACTIVITY_FIELD,
            Update::CHANGE_ACTIVITY_YES_FIELD,
            Update::CHANGE_ACTIVITY_NO_FIELD,
            Update::TRANSLATES_FIELD,
            Update::LANGUAGE_FIELD,
            Update::NAME_FIELD,
            Update::SHORT_DESCRIPTION_FIELD,
            Update::DESCRIPTION_FIELD,
            Update::CATEGORIES_FIELD,
            $this->audioPathPrefix,
            new ImageFiltersDto(),
            new AuthorFiltersDto(),
            new AudioFiltersDto(),
            $categories
        );

        $html = $this->view
            ->setController($this->getController(), $decodedRoute)
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(string $dynamicRoute): string
    {
        return 'Admin Article page view ' . $dynamicRoute;
    }

    public function getDynamicRoutes(): array
    {
        return [];
    }
}
