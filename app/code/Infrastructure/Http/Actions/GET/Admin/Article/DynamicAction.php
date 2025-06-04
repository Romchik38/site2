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
use Romchik38\Server\Http\Views\ViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Article\AdminView\AdminView;
use Romchik38\Site2\Application\Article\AdminView\CouldNotFindException;
use Romchik38\Site2\Application\Article\AdminView\NoSuchArticleException;
use Romchik38\Site2\Application\Article\ArticleService\Commands\Update;
use Romchik38\Site2\Application\Language\List\ListService;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\DynamicAction\ImageFiltersDto;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\DynamicAction\ViewDto;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface;

use function sprintf;
use function urldecode;

final class DynamicAction extends AbstractMultiLanguageAction implements DynamicActionInterface
{
    public const ERROR_MESSAGE_KEY = 'server-error.message';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly ListService $languageService,
        private readonly AdminView $articleViewService,
        private readonly Site2SessionInterface $session,
        private readonly CsrfTokenGeneratorInterface $csrfTokenGenerator,
        private readonly LoggerInterface $logger,
        private readonly UrlbuilderInterface $urlbuilder
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $dynamicRoute = new Name($request->getAttribute(self::TYPE_DYNAMIC_ACTION));
        $decodedRoute = urldecode($dynamicRoute());

        $uriList = $this->urlbuilder->fromArray(['root', 'admin', 'article']);

        try {
            $id         = new ArticleId($decodedRoute);
            $articleDto = $this->articleViewService->find($id);
        } catch (NoSuchArticleException $e) {
            throw new ActionNotFoundException('Article with id %s not exist');
        } catch (InvalidArgumentException $e) {
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD,
                $this->translateService->t($this::ERROR_MESSAGE_KEY)
            );
            return new RedirectResponse($uriList);
        } catch (CouldNotFindException $e) {
            $this->logger->error($e->getMessage());
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD,
                $this->translateService->t($this::ERROR_MESSAGE_KEY)
            );
            return new RedirectResponse($uriList);
        }

        $languages = $this->languageService->getAll();

        $csrfToken = $this->csrfTokenGenerator->asBase64();
        $this->session->setData($this->session::ADMIN_CSRF_TOKEN_FIELD, $csrfToken);

        $dto = new ViewDto(
            sprintf('Article view id %s', $decodedRoute),
            sprintf('Article view page with id %s', $decodedRoute),
            $this->session::ADMIN_CSRF_TOKEN_FIELD,
            $csrfToken,
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
            new ImageFiltersDto()
        );

        $html = $this->view
            ->setController($this->getController(), $dynamicRoute())
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(string $dynamicRoute): string
    {
        return 'Admin Article page view ' . urldecode($dynamicRoute);
    }

    public function getDynamicRoutes(): array
    {
        return [];
    }
}
