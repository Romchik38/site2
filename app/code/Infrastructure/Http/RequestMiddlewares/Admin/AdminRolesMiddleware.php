<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\RequestMiddlewares\Admin;

use InvalidArgumentException;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Romchik38\Server\Http\Controller\Middleware\RequestMiddlewareInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\AdminUser\AdminUserService\AdminUserService;
use Romchik38\Site2\Application\AdminUser\AdminUserService\Commands\CheckRoles;
use Romchik38\Site2\Application\AdminUser\AdminUserService\Exceptions\AdminUserNotActiveException;
use Romchik38\Site2\Application\AdminUser\AdminUserService\Exceptions\CouldNotCheckRolesException;
use Romchik38\Site2\Application\AdminUser\AdminUserService\Exceptions\NoSuchAdminUserException;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;

final class AdminRolesMiddleware implements RequestMiddlewareInterface
{
    private const NOT_ENOUGH_PERMISSIONS_MESSAGE_KEY = 'admin.roles.you-do-not-have-enough-permissions';

    /** @param array<int,string> $allowedRoles*/
    public function __construct(
        private readonly array $allowedRoles,
        private readonly Site2SessionInterface $session,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly AdminUserService $adminUserService,
        private readonly TranslateInterface $translate,
        private readonly LoggerInterface $logger
    ) {
    }

    public function __invoke(ServerRequestInterface $request): ?ResponseInterface
    {
        $urlRoot  = $this->urlbuilder->fromArray(['root']);
        $urlLogin = $this->urlbuilder->fromArray(['root', 'login', 'admin']);
        $urlAdmin = $this->urlbuilder->fromArray(['root', 'admin']);

        $adminUser = $this->session->getData(Site2SessionInterface::ADMIN_USER_FIELD);
        if ($adminUser === null) {
            // not admin user
            return new RedirectResponse($urlRoot);
        }

        $command = CheckRoles::firstMatch($this->allowedRoles, $adminUser);

        try {
            $checkResult = $this->adminUserService->checkRoles($command);
            if ($checkResult === true) {
                return null;
            } else {
                $this->session->setData(
                    Site2SessionInterface::MESSAGE_FIELD,
                    $this->translate->t($this::NOT_ENOUGH_PERMISSIONS_MESSAGE_KEY)
                );
                return new RedirectResponse($urlAdmin);
            }
        } catch (AdminUserNotActiveException $e) {
            // user is logged in, but was deactivated
            $this->session->logout();
            $this->logger->error($e->getMessage());
            return new RedirectResponse($urlLogin);
        } catch (NoSuchAdminUserException $e) {
            // user is logged in, but it username was changed or deleted
            $this->session->logout();
            $this->logger->error($e->getMessage());
            return new RedirectResponse($urlLogin);
        } catch (CouldNotCheckRolesException $e) {
            // problem with database etc.
            $this->session->logout();
            $this->logger->error($e->getMessage());
            return new RedirectResponse($urlLogin);
        } catch (InvalidArgumentException $e) {
            // problem with command data (session etc)
            $this->session->logout();
            $this->logger->error($e->getMessage());
            return new RedirectResponse($urlLogin);
        }
    }
}
