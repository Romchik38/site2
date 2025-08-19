<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image\New;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Http\Views\ControllerViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\AdminVisitor\AdminVisitorService;
use Romchik38\Site2\Application\Image\AdminView\AdminViewService;
use Romchik38\Site2\Application\Image\AdminView\RepositoryException as ImageViewRepositoryException;
use Romchik38\Site2\Application\Image\ImageService\Create;
use Romchik38\Site2\Application\Language\List\Exceptions\RepositoryException as LanguageRepositoryException;
use Romchik38\Site2\Application\Language\List\ListService;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image\New\DefaultAction\ViewDto;

use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public const ERROR_MESSAGE_KEY = 'server-error.message';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ControllerViewInterface $view,
        private readonly ListService $languageService,
        private readonly LoggerInterface $logger,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly AdminViewService $adminViewService,
        private readonly AdminVisitorService $adminVisitorService,
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $urlList            = $this->urlbuilder->fromArray(['root', 'admin', 'image']);
        $errorServerMessage = $this->translateService->t($this::ERROR_MESSAGE_KEY);

        try {
            $languages = $this->languageService->getAll();
            $authors   = $this->adminViewService->listAuthors();
        } catch (LanguageRepositoryException $e) {
            $this->logger->error($e->getMessage());
            $this->adminVisitorService->changeMessage($errorServerMessage);
            return new RedirectResponse($urlList);
        } catch (ImageViewRepositoryException $e) {
            $this->logger->error($e->getMessage());
            $this->adminVisitorService->changeMessage($errorServerMessage);
            return new RedirectResponse($urlList);
        }

        $imageRequirements = $this->adminViewService->imageRequirements();

        $dto = new ViewDto(
            sprintf('Create new Image'),
            sprintf('Create new Image page'),
            $languages,
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
