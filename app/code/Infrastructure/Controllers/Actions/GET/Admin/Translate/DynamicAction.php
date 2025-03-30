<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Translate;

use InvalidArgumentException;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DynamicActionInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Controllers\Errors\ActionNotFoundException;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Services\Translate\TranslateInterface;
use Romchik38\Site2\Application\Language\ListView\ListViewService;
use Romchik38\Site2\Application\Translate\TranslateService\Update;
use Romchik38\Site2\Application\Translate\View\ViewService;
use Romchik38\Site2\Domain\Translate\NoSuchTranslateException;
use Romchik38\Site2\Domain\Translate\VO\Identifier;
use Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Translate\DynamicAction\ViewDto;
use Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface;
use Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface;

use function sprintf;

final class DynamicAction extends AbstractMultiLanguageAction implements DynamicActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly ViewService $viewService,
        private readonly Site2SessionInterface $session,
        private readonly CsrfTokenGeneratorInterface $csrfTokenGenerator,
        private readonly ListViewService $languageService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(string $dynamicRoute): ResponseInterface
    {
        $decodedRoute = urldecode($dynamicRoute);
        try {
            $translateId = new Identifier($decodedRoute);
        } catch (InvalidArgumentException $e) {
            throw new ActionNotFoundException($e->getMessage());
        }

        try {
            $translateDto = $this->viewService->find($translateId);
        } catch (NoSuchTranslateException $e) {
            throw new ActionNotFoundException($e->getMessage());
        }

        $languages = $this->languageService->getAll();

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
