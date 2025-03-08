<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Middlewares\Admin;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Middleware\RequestMiddlewareInterface;
use Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface;

final class AdminLoginMiddleware implements RequestMiddlewareInterface
{
    protected const MUST_BE_LOGGED_IN_MESSAGE_KEY = 'admin.logout.you-must-login-first';

    /** @param array<int,string> $allowedRoles*/
    public function __construct(
        protected readonly Site2SessionInterface $session,
        protected readonly UrlbuilderInterface $urlbuilder
    ) {
    }

    public function __invoke(): ?ResponseInterface
    {
        $adminUser = $this->session->getData(Site2SessionInterface::ADMIN_USER_FIELD);
        $urlLogin = $this->urlbuilder->fromArray(['root', 'login', 'admin']);

        if ($adminUser === null) {
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD,
                /** @todo translate */
                $this::MUST_BE_LOGGED_IN_MESSAGE_KEY
            );
            return new RedirectResponse($urlLogin);
        }
        
        if ($adminUser === '') {
            $this->session->logout();
            return new RedirectResponse($urlLogin);
        }

        return null;
    }
}