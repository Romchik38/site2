<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\RequestMiddlewares\Admin;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Middleware\RequestMiddlewareInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Application\AdminUserRoles\AdminUserRolesService;
use Romchik38\Site2\Application\AdminUserRoles\ListRoles;
use Romchik38\Site2\Domain\AdminUser\AdminUserNotActiveException;
use Romchik38\Site2\Domain\AdminUser\NoSuchAdminUserException;
use Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface;

final class AdminRolesMiddleware implements RequestMiddlewareInterface
{
    protected const NOT_ENOUGH_PERMISSIONS_MESSAGE_KEY = 'admin.roles.you-do-not-have-enough-permissions';

    /** @param array<int,string> $allowedRoles*/
    public function __construct(
        protected readonly array $allowedRoles,
        protected readonly Site2SessionInterface $session,
        protected readonly UrlbuilderInterface $urlbuilder,
        protected readonly AdminUserRolesService $adminUserRoles,
        protected readonly TranslateInterface $translate
    ) {
    }

    public function __invoke(): ?ResponseInterface
    {
        $adminUser = (string) $this->session->getData(Site2SessionInterface::ADMIN_USER_FIELD);
        $urlLogin  = $this->urlbuilder->fromArray(['root', 'login', 'admin']);
        $urlAdmin  = $this->urlbuilder->fromArray(['root', 'admin']);

        $command = new ListRoles($adminUser);
        try {
            $adminRoles = $this->adminUserRoles->listRolesByUsername($command);
            foreach ($this->allowedRoles as $role) {
                if ($adminRoles->hasRole($role)) {
                    return null;
                }
            }
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD,
                $this->translate->t($this::NOT_ENOUGH_PERMISSIONS_MESSAGE_KEY)
            );
            return new RedirectResponse($urlAdmin);
        } catch (NoSuchAdminUserException) {
            // user is logged in, but it username was changed or deleted
            $this->session->logout();
            return new RedirectResponse($urlLogin);
        } catch (AdminUserNotActiveException) {
            // user is logged in, but was deactivated
            $this->session->logout();
            return new RedirectResponse($urlLogin);
        }
        /**
         * InvalidArgumentException must be catched later and logged to file
         * There is nothing to show the admin user. It will see common server error page
         */
        return null;
    }
}
