<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio;

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
use Romchik38\Site2\Application\AdminVisitor\AdminVisitorService;
use Romchik38\Site2\Application\Audio\AdminView\AdminView;
use Romchik38\Site2\Application\Audio\AdminView\CouldNotFindException;
use Romchik38\Site2\Application\Audio\AdminView\NoSuchAudioException;
use Romchik38\Site2\Application\Audio\AudioService\Update;
use Romchik38\Site2\Application\Audio\AudioService\UpdateTranslate;
use Romchik38\Site2\Application\Language\List\ListService;
use Romchik38\Site2\Domain\Audio\VO\Id;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\DynamicAction\ViewDto;

use function sprintf;

final class DynamicAction extends AbstractMultiLanguageAction implements DynamicActionInterface
{
    public const ERROR_MESSAGE_KEY = 'server-error.message';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly AdminView $adminViewService,
        private readonly ListService $languageService,
        private readonly LoggerInterface $logger,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly string $audioPathPrefix,
        private readonly AdminVisitorService $adminVisitorService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $dynamicRoute = new Name($request->getAttribute(self::TYPE_DYNAMIC_ACTION));
        try {
            $audioId = Id::fromString($dynamicRoute());
        } catch (InvalidArgumentException $e) {
            throw new ActionNotFoundException($e->getMessage());
        }

        try {
            $audioDto = $this->adminViewService->find($audioId);
        } catch (NoSuchAudioException) {
            throw new ActionNotFoundException(sprintf(
                'Audio with id %s not exist',
                $audioId()
            ));
        } catch (CouldNotFindException $e) {
            $this->logger->error($e->getMessage());
            $uri = $this->urlbuilder->fromArray(['root', 'admin', 'audio']);
            $this->adminVisitorService->changeMessage($this->translateService->t($this::ERROR_MESSAGE_KEY));
            return new RedirectResponse($uri);
        }

        $languages = $this->languageService->getAll();

        $visitor = $this->adminVisitorService->getVisitor();

        $dto = new ViewDto(
            sprintf('Audio view id %s', $audioId()),
            sprintf('Audio view page with id %s', $audioId()),
            $audioDto,
            $visitor->getCsrfTokenField(),
            $visitor->getCsrfToken(),
            Update::ID_FIELD,
            Update::NAME_FIELD,
            Update::CHANGE_ACTIVITY_FIELD,
            Update::CHANGE_ACTIVITY_YES_FIELD,
            Update::CHANGE_ACTIVITY_NO_FIELD,
            $languages,
            $this->audioPathPrefix,
            UpdateTranslate::ID_FIELD,
            UpdateTranslate::LANGUAGE_FIELD
        );

        $html = $this->view
            ->setController($this->getController(), $dynamicRoute())
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(string $dynamicRoute): string
    {
        return 'Admin Audio page view ' . $dynamicRoute;
    }

    public function getDynamicRoutes(): array
    {
        return [];
    }
}
