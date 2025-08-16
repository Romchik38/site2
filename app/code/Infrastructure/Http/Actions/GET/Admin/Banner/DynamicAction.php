<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Banner;

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
use Romchik38\Server\Http\Views\ControllerViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\AdminVisitor\AdminVisitorService;
use Romchik38\Site2\Application\Banner\AdminView\AdminView;
use Romchik38\Site2\Application\Banner\AdminView\Exceptions\CouldNotFindException;
use Romchik38\Site2\Application\Banner\AdminView\Exceptions\NoSuchBannerException;
use Romchik38\Site2\Application\Banner\BannerService\Commands\Update;
use Romchik38\Site2\Domain\Banner\VO\Priority;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Banner\DynamicAction\ViewDto;

use function sprintf;
use function urldecode;

final class DynamicAction extends AbstractMultiLanguageAction implements DynamicActionInterface
{
    public const SERVER_ERROR_MESSAGE = 'server-error.message';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ControllerViewInterface $view,
        private readonly AdminView $viewService,
        private readonly LoggerInterface $logger,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly AdminVisitorService $adminVisitorService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $dynamicRoute = new Name($request->getAttribute(self::TYPE_DYNAMIC_ACTION));
        } catch (InvalidArgumentException $e) {
            throw new ActionNotFoundException($e->getMessage());
        }

        $decodedRoute = urldecode($dynamicRoute());
        $redirectUri  = $this->urlbuilder->fromArray(['root', 'admin', 'banner']);

        try {
            $bannerDto = $this->viewService->find($decodedRoute);
        } catch (NoSuchBannerException $e) {
            throw new ActionNotFoundException($e->getMessage());
        } catch (CouldNotFindException $e) {
            $this->logger->error($e->getMessage());
            $this->adminVisitorService->changeMessage($this->translateService->t($this::SERVER_ERROR_MESSAGE));
            return new RedirectResponse($redirectUri);
        } catch (InvalidArgumentException $e) {
            $this->logger->error($e->getMessage());
            $this->adminVisitorService->changeMessage($e->getMessage());
            return new RedirectResponse($redirectUri);
        }

        $visitor = $this->adminVisitorService->getVisitor();

        $dto = new ViewDto(
            sprintf('Banner view id %s', $decodedRoute),
            sprintf('Banner view page with id %s', $decodedRoute),
            $bannerDto,
            $visitor->getCsrfTokenField(),
            $visitor->getCsrfToken(),
            Update::ID_FIELD,
            Update::NAME_FIELD,
            Update::PRIORITY_FIELD,
            Update::CHANGE_ACTIVITY_FIELD,
            Update::CHANGE_ACTIVITY_YES_FIELD,
            Update::CHANGE_ACTIVITY_NO_FIELD,
            Priority::MIN_PRIORITY,
            Priority::MAX_PRIORITY
        );

        $html = $this->view
            ->setController($this->getController(), $dynamicRoute())
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(string $dynamicRoute): string
    {
        return 'Admin Banner view page ' . urldecode($dynamicRoute);
    }

    public function getDynamicRoutes(): array
    {
        return [];
    }
}
