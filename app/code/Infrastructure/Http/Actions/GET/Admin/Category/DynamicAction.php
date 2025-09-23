<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Category;

use InvalidArgumentException;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DynamicActionInterface;
use Romchik38\Server\Http\Controller\Errors\ActionNotFoundException;
use Romchik38\Server\Http\Controller\Errors\DynamicActionLogicException;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Http\Views\ControllerViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\AdminVisitor\AdminVisitorService;
use Romchik38\Site2\Application\Category\AdminView\CouldNotFindException;
use Romchik38\Site2\Application\Category\AdminView\NoSuchCategoryException;
use Romchik38\Site2\Application\Category\AdminView\ViewService;
use Romchik38\Site2\Application\Category\CategoryService\Commands\Update;
use Romchik38\Site2\Application\Language\List\Exceptions\RepositoryException as LanguageException;
use Romchik38\Site2\Application\Language\List\ListService;
use Romchik38\Site2\Domain\Category\VO\Identifier as CategoryId;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Category\DynamicAction\ViewDto;

use function sprintf;

final class DynamicAction extends AbstractMultiLanguageAction implements DynamicActionInterface
{
    public const SERVER_ERROR_MESSAGE = 'server-error.message';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ControllerViewInterface $view,
        private readonly ViewService $viewService,
        private readonly ListService $languageService,
        private readonly LoggerInterface $logger,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly AdminVisitorService $adminVisitorService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $decodedRoute = $request->getAttribute(self::TYPE_DYNAMIC_ACTION);
        if (! is_string($decodedRoute)) {
            throw new DynamicActionLogicException('param decodedRoute is invalid');
        }
        
        try {
            $categoryId = new CategoryId($decodedRoute);
        } catch (InvalidArgumentException $e) {
            throw new ActionNotFoundException($e->getMessage());
        }

        $redirectUri        = $this->urlbuilder->fromArray(['root', 'admin', 'category']);
        $serverErrorMessage = $this->translateService->t($this::SERVER_ERROR_MESSAGE);

        try {
            $categoryDto = $this->viewService->find($categoryId);
        } catch (NoSuchCategoryException $e) {
            throw new ActionNotFoundException($e->getMessage());
        } catch (CouldNotFindException $e) {
            $this->logger->error($e->getMessage());
            $this->adminVisitorService->changeMessage($serverErrorMessage);
            return new RedirectResponse($redirectUri);
        }

        try {
            $languages = $this->languageService->getAll();
        } catch (LanguageException $e) {
            $this->logger->error($e->getMessage());
            $this->adminVisitorService->changeMessage($serverErrorMessage);
            return new RedirectResponse($redirectUri);
        }

        $dto = new ViewDto(
            sprintf('Category view id %s', $categoryId()),
            sprintf('Category view page with id %s', $categoryId()),
            $categoryDto,
            Update::ID_FIELD,
            Update::TRANSLATES_FIELD,
            Update::LANGUAGE_FIELD,
            Update::NAME_FIELD,
            Update::DESCRIPTION_FIELD,
            $languages,
            Update::CHANGE_ACTIVITY_FIELD,
            Update::CHANGE_ACTIVITY_YES_FIELD,
            Update::CHANGE_ACTIVITY_NO_FIELD
        );

        $html = $this->view
            ->setController($this->getController(), $decodedRoute)
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(string $dynamicRoute): string
    {
        return 'Admin Category view page ' . $dynamicRoute;
    }

    public function getDynamicRoutes(): array
    {
        return [];
    }
}
