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
use Romchik38\Server\Http\Views\ViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Banner\AdminView\AdminView;
use Romchik38\Site2\Application\Banner\AdminView\Exceptions\CouldNotFindException;
use Romchik38\Site2\Application\Banner\AdminView\Exceptions\NoSuchBannerException;
use Romchik38\Site2\Application\Banner\BannerService\Commands\Update;
use Romchik38\Site2\Domain\Banner\VO\Priority;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Banner\DynamicAction\ViewDto;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface;

use function sprintf;
use function urldecode;

final class DynamicAction extends AbstractMultiLanguageAction implements DynamicActionInterface
{
    public const SERVER_ERROR_MESSAGE = 'server-error.message';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly AdminView $viewService,
        private readonly Site2SessionInterface $session,
        private readonly CsrfTokenGeneratorInterface $csrfTokenGenerator,
        private readonly LoggerInterface $logger,
        private readonly UrlbuilderInterface $urlbuilder
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
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD,
                $this::SERVER_ERROR_MESSAGE
            );
            return new RedirectResponse($redirectUri);
        }

        $csrfToken = $this->csrfTokenGenerator->asBase64();
        $this->session->setData($this->session::ADMIN_CSRF_TOKEN_FIELD, $csrfToken);

        $dto = new ViewDto(
            sprintf('Banner view id %s', $decodedRoute),
            sprintf('Banner view page with id %s', $decodedRoute),
            $bannerDto,
            $this->session::ADMIN_CSRF_TOKEN_FIELD,
            $csrfToken,
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
