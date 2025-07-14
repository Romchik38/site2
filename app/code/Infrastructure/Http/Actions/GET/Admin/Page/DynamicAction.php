<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Page;

use InvalidArgumentException;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DynamicActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Http\Views\ViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Language\List\Exceptions\RepositoryException as LanguageException;
use Romchik38\Site2\Application\Language\List\ListService;
use Romchik38\Site2\Application\Page\AdminView\AdminView;
use Romchik38\Site2\Application\Page\AdminView\CouldNotFindException;
use Romchik38\Site2\Application\Page\AdminView\NoSuchPageException;
use Romchik38\Site2\Application\Page\PageService\Commands\Update;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Page\DynamicAction\ViewDto;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface;

use function sprintf;

final class DynamicAction extends AbstractMultiLanguageAction implements DynamicActionInterface
{
    public const SERVER_ERROR_MESSAGE = 'server-error.message';
    public const DESCRIPTION          = 'Page view with id %s';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly AdminView $viewService,
        private readonly Site2SessionInterface $session,
        private readonly CsrfTokenGeneratorInterface $csrfTokenGenerator,
        private readonly ListService $languageService,
        private readonly LoggerInterface $logger,
        private readonly UrlbuilderInterface $urlbuilder
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $dynamicRoute = $request->getAttribute(self::TYPE_DYNAMIC_ACTION);

        $redirectUri = $this->urlbuilder->fromArray(['root', 'admin', 'page']);

        try {
            $pageDto = $this->viewService->find($dynamicRoute);
        } catch (InvalidArgumentException $e) {
            $this->session->setData(Site2SessionInterface::MESSAGE_FIELD, $e->getMessage());
            return new RedirectResponse($redirectUri);
        } catch (NoSuchPageException $e) {
            $this->session->setData(Site2SessionInterface::MESSAGE_FIELD, $e->getMessage());
            return new RedirectResponse($redirectUri);
        } catch (CouldNotFindException $e) {
            $this->logger->error($e->getMessage());
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD,
                $this::SERVER_ERROR_MESSAGE
            );
            return new RedirectResponse($redirectUri);
        }

        try {
            $languages = $this->languageService->getAll();
        } catch (LanguageException $e) {
            $this->logger->error($e->getMessage());
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD,
                $this::SERVER_ERROR_MESSAGE
            );
            return new RedirectResponse($redirectUri);
        }

        $csrfToken = $this->csrfTokenGenerator->asBase64();
        $this->session->setData($this->session::ADMIN_CSRF_TOKEN_FIELD, $csrfToken);

        $dto = new ViewDto(
            sprintf('Page view id %s', $pageDto->getId()),
            sprintf(self::DESCRIPTION, $pageDto->getId()),
            $pageDto,
            $this->session::ADMIN_CSRF_TOKEN_FIELD,
            $csrfToken,
            Update::ID_FIELD,
            Update::URL_FIELD,
            Update::TRANSLATES_FIELD,
            Update::LANGUAGE_FIELD,
            Update::NAME_FIELD,
            Update::DESCRIPTION_FIELD,
            Update::SHORT_DESCRIPTION_FIELD,
            $languages,
            Update::CHANGE_ACTIVITY_FIELD,
            Update::CHANGE_ACTIVITY_YES_FIELD,
            Update::CHANGE_ACTIVITY_NO_FIELD
        );

        $html = $this->view
            ->setController($this->getController(), $dynamicRoute)
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(string $dynamicRoute): string
    {
        return sprintf(self::DESCRIPTION, $dynamicRoute);
    }

    public function getDynamicRoutes(): array
    {
        return [];
    }
}
