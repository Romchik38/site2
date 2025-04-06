<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Image\New;

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
use Romchik38\Site2\Application\Image\ImageService\Create;
use Romchik38\Site2\Application\Language\ListView\ListViewService;
use Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Image\New\DefaultAction\ViewDto;
use Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface;
use Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface;
use Romchik38\Site2\Application\Language\ListView\RepositoryException as LanguageRepositoryException;
use Romchik38\Site2\Application\Image\AdminView\AdminViewService;
use Romchik38\Site2\Application\Image\AdminView\RepositoryException as ImageViewRepositoryException;

use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
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
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly AdminViewService $adminViewService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(): ResponseInterface
    {
        /** @todo test */
        $error = false;
        try {
            $languages = $this->languageService->getAll();
            $authors = $this->adminViewService->listAuthors();
        } catch (LanguageRepositoryException $e) {
            $error = true;
            $message = $this->translateService->t($this::ERROR_MESSAGE_KEY);
        } catch (ImageViewRepositoryException $e) {
            $error = true;
            $message = $this->translateService->t($this::ERROR_MESSAGE_KEY);
        }

        if ($error === true) {
            $this->logger->error($e->getMessage());
            $urlList = $this->urlbuilder->fromArray(['root', 'admin', 'image']);
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD,
                $message
            );
            return new RedirectResponse($urlList);
        }

        $imageRequirements = $this->adminViewService->imageRequirements();

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
            Create::TRANSLATES_FIELD,
            Create::LANGUAGE_FIELD,
            Create::DESCRIPTION_FIELD,
            $authors,
            $imageRequirements,
            Create::FILE_FIELD,
            Create::FOLDER_FIELD,
            Create::ALLOWED_FOLDERS
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
