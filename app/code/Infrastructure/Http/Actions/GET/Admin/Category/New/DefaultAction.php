<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Category\New;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\LoggerServerInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Services\Translate\TranslateInterface;
use Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Application\Category\CategoryService\Commands\Create;
use Romchik38\Site2\Application\Language\List\Exceptions\RepositoryException as LanguageException;
use Romchik38\Site2\Application\Language\List\ListViewService;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Category\New\DefaultAction\ViewDto;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public const SERVER_ERROR_MESSAGE = 'server-error.message';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly Site2SessionInterface $session,
        private readonly CsrfTokenGeneratorInterface $csrfTokenGenerator,
        private readonly ListViewService $languageService,
        private readonly LoggerServerInterface $logger,
        private readonly UrlbuilderInterface $urlbuilder
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(): ResponseInterface
    {
        $redirectUri = $this->urlbuilder->fromArray(['root', 'admin', 'category']);

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
            'Create new category',
            'Create new category page',
            $this->session::ADMIN_CSRF_TOKEN_FIELD,
            $csrfToken,
            Create::CATEGORY_ID_FIELD,
            Create::TRANSLATES_FIELD,
            Create::LANGUAGE_FIELD,
            Create::NAME_FIELD,
            Create::DESCRIPTION_FIELD,
            $languages
        );

        $html = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return 'Admin create new category page ';
    }
}
