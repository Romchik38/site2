<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\RequestMiddlewares\Admin;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Middleware\RequestMiddlewareInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\AdminVisitor\AdminVisitorService;
use Romchik38\Site2\Application\Visitor\VisitorService;

final class AdminLoginMiddleware implements RequestMiddlewareInterface
{
    public const ATTRIBUTE_NAME = 'admin_login_middleware';

    private const MUST_BE_LOGGED_IN_MESSAGE_KEY = 'logout.you-must-login-first';

    public function __construct(
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly TranslateInterface $translate,
        private readonly AdminVisitorService $adminVisitorService,
        private readonly VisitorService $visitorService
    ) {
    }

    public function __invoke(ServerRequestInterface $request): ?ResponseInterface
    {
        $adminVisitor = $this->adminVisitorService->getVisitor();
        $urlLogin     = $this->urlbuilder->fromArray(['root', 'login', 'admin']);

        if ($adminVisitor->getUserName() === null) {
            $this->visitorService->changeMessage($this->translate->t($this::MUST_BE_LOGGED_IN_MESSAGE_KEY));
            return new RedirectResponse($urlLogin);
        }

        return null;
    }

    public function getAttributeName(): string
    {
        return $this::ATTRIBUTE_NAME;
    }
}
