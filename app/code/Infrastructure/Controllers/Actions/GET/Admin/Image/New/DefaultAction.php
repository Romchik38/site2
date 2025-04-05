<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Image\New;

use InvalidArgumentException;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Controllers\Actions\DynamicActionInterface;
use Romchik38\Server\Api\Services\LoggerServerInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Controllers\Errors\ActionNotFoundException;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Services\Translate\TranslateInterface;
use Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Application\Image\AdminView\AdminViewService;
use Romchik38\Site2\Application\Image\ImageService\Create;
use Romchik38\Site2\Application\Language\ListView\ListViewService;
use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Image\New\DefaultAction\ViewDto;
use Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface;
use Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface;
use Romchik38\Site2\Application\Language\ListView\RepositoryException;

use function sprintf;

final class DynamicAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    /** @todo usage */
    public const ERROR_MESSAGE_KEY = 'server-error.message';

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
        /** @todo test */
        try {
            $languages = $this->languageService->getAll();
        } catch (RepositoryException) {
            $urlList = $this->urlbuilder->fromArray(['root', 'admin', 'image']);
            $message = $this->translateService->t($this::ERROR_MESSAGE_KEY);
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD,
                $message
            );
            return new RedirectResponse($urlList);
        }

        $csrfToken = $this->csrfTokenGenerator->asBase64();
        $this->session->setData($this->session::ADMIN_CSRF_TOKEN_FIELD, $csrfToken);

        $dto = new ViewDto(
            sprintf('Create new Image'),
            sprintf('Create new Image page'),
            $languages,
            $this->session::ADMIN_CSRF_TOKEN_FIELD,
            $csrfToken,
            Create::NAME_FIELD,
            Create::AUTHOR_ID_FIELD,
            Create::CHANGE_ACTIVITY_FIELD,
            Create::CHANGE_ACTIVITY_YES_FIELD,
            Create::CHANGE_ACTIVITY_NO_FIELD,
            Create::TRANSLATES_FIELD,
            Create::LANGUAGE_FIELD,
            Create::DESCRIPTION_FIELD,
        );

        $html = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return 'Admin Image create new page';
    }
}
