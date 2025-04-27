<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image;

use InvalidArgumentException;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DynamicActionInterface;
use Romchik38\Server\Api\Services\LoggerServerInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Controllers\Errors\ActionNotFoundException;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Services\Translate\TranslateInterface;
use Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Application\Image\AdminView\AdminViewService;
use Romchik38\Site2\Application\Image\AdminView\CouldNotFindException;
use Romchik38\Site2\Application\Image\ImageService\Update;
use Romchik38\Site2\Application\Language\List\ListViewService;
use Romchik38\Site2\Domain\Image\NoSuchImageException;
use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image\DynamicAction\ViewDto;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface;

use function sprintf;

final class DynamicAction extends AbstractMultiLanguageAction implements DynamicActionInterface
{
    public const ERROR_MESSAGE_KEY = 'server-error.message';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly AdminViewService $adminViewService,
        private readonly Site2SessionInterface $session,
        private readonly CsrfTokenGeneratorInterface $csrfTokenGenerator,
        private readonly ListViewService $languageService,
        private readonly LoggerServerInterface $logger,
        private readonly UrlbuilderInterface $urlbuilder
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(string $dynamicRoute): ResponseInterface
    {
        try {
            $imageId = Id::fromString($dynamicRoute);
        } catch (InvalidArgumentException $e) {
            throw new ActionNotFoundException($e->getMessage());
        }

        try {
            $result = $this->adminViewService->find($imageId);
        } catch (NoSuchImageException) {
            throw new ActionNotFoundException(sprintf(
                'Image with id %s not exist',
                (string) $imageId
            ));
        } catch (CouldNotFindException $e) {
            $this->logger->error($e->getMessage());
            $uri = $this->urlbuilder->fromArray(['root', 'admin', 'image']);
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD,
                $this->translateService->t($this::ERROR_MESSAGE_KEY)
            );
            return new RedirectResponse($uri);
        }

        $languages = $this->languageService->getAll();

        $csrfToken = $this->csrfTokenGenerator->asBase64();
        $this->session->setData($this->session::ADMIN_CSRF_TOKEN_FIELD, $csrfToken);

        $dto = new ViewDto(
            sprintf('Image view id %s', (string) $imageId),
            sprintf('Image view page with id %s', (string) $imageId),
            $result->image,
            $result->metadata,
            $result->imageFrontendPath,
            $languages,
            $this->session::ADMIN_CSRF_TOKEN_FIELD,
            $csrfToken,
            Update::ID_FIELD,
            Update::NAME_FIELD,
            Update::AUTHOR_ID_FIELD,
            Update::CHANGE_AUTHOR_ID_FIELD,
            Update::CHANGE_AUTHOR_FIELD,
            Update::CHANGE_ACTIVITY_FIELD,
            Update::CHANGE_ACTIVITY_YES_FIELD,
            Update::CHANGE_ACTIVITY_NO_FIELD,
            Update::TRANSLATES_FIELD,
            Update::LANGUAGE_FIELD,
            Update::DESCRIPTION_FIELD,
        );

        $html = $this->view
            ->setController($this->getController(), $dynamicRoute)
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(string $dynamicRoute): string
    {
        return 'Admin Image page view ' . $dynamicRoute;
    }

    public function getDynamicRoutes(): array
    {
        return [];
    }
}
