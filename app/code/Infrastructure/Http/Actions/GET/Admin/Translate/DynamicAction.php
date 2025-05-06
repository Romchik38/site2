<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Translate;

use InvalidArgumentException;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DynamicActionInterface;
use Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Controllers\Errors\ActionNotFoundException;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Application\Language\List\Exceptions\RepositoryException as LanguageRepositoryException;
use Romchik38\Site2\Application\Language\List\ListService;
use Romchik38\Site2\Application\Translate\TranslateService\Update;
use Romchik38\Site2\Application\Translate\View\Exceptions\CouldNotFindException;
use Romchik38\Site2\Application\Translate\View\Exceptions\NoSuchTranslateException;
use Romchik38\Site2\Application\Translate\View\ViewService;
use Romchik38\Site2\Domain\Translate\VO\Identifier;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Translate\DynamicAction\ViewDto;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface;

use function sprintf;
use function urldecode;

final class DynamicAction extends AbstractMultiLanguageAction implements DynamicActionInterface
{
    public const SERVER_ERROR = 'server-error.message';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly ViewService $viewService,
        private readonly Site2SessionInterface $session,
        private readonly CsrfTokenGeneratorInterface $csrfTokenGenerator,
        private readonly ListService $languageService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly LoggerServerInterface $logger
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(string $dynamicRoute): ResponseInterface
    {
        $decodedRoute = urldecode($dynamicRoute);
        $uriRedirect  = $this->urlbuilder->fromArray(['root', 'admin', 'translate']);
        $messageError = $this->translateService->t($this::SERVER_ERROR);

        try {
            $translateId = new Identifier($decodedRoute);
        } catch (InvalidArgumentException $e) {
            $this->session->setData(Site2SessionInterface::MESSAGE_FIELD, $e->getMessage());
            return new RedirectResponse($uriRedirect);
        }

        try {
            $translateDto = $this->viewService->find($translateId);
        } catch (NoSuchTranslateException $e) {
            throw new ActionNotFoundException($e->getMessage());
        } catch (CouldNotFindException $e) {
            $this->session->setData(Site2SessionInterface::MESSAGE_FIELD, $messageError);
            $this->logger->error($e->getMessage());
            return new RedirectResponse($uriRedirect);
        }

        try {
            $languages = $this->languageService->getAll();
        } catch (LanguageRepositoryException $e) {
            $this->session->setData(Site2SessionInterface::MESSAGE_FIELD, $messageError);
            $this->logger->error($e->getMessage());
            return new RedirectResponse($uriRedirect);
        }

        $csrfToken = $this->csrfTokenGenerator->asBase64();
        $this->session->setData($this->session::ADMIN_CSRF_TOKEN_FIELD, $csrfToken);

        $dto = new ViewDto(
            sprintf('Translate view id %s', $translateId()),
            sprintf('Translate view page with id %s', $translateId()),
            $translateDto,
            $this->session::ADMIN_CSRF_TOKEN_FIELD,
            $csrfToken,
            Update::ID_FIELD,
            Update::TRANSLATES_FIELD,
            Update::LANGUAGE_FIELD,
            Update::PHRASE_FIELD,
            $languages
        );

        $html = $this->view
            ->setController($this->getController(), $dynamicRoute)
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(string $dynamicRoute): string
    {
        return 'Admin Translate page view ' . $dynamicRoute;
    }

    public function getDynamicRoutes(): array
    {
        return [];
    }
}
