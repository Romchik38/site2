<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Logout;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\AdminVisitor\AdminVisitorService;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    private const LOGOUT_MESSAGE_KEY = 'admin.logout.you-must-login-first';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly Site2SessionInterface $session,
        private readonly AdminVisitorService $adminVisitorService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $visitor = $this->adminVisitorService->getVisitor();
        if ($visitor->getUserName() !== null) {
            $this->adminVisitorService->logout();
            $url = $this->urlbuilder->fromArray(['root', 'login', 'admin']);
            return new RedirectResponse($url);
        } else {
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD,
                $this::LOGOUT_MESSAGE_KEY
            );
            $url = $this->urlbuilder->fromArray(['root', 'login', 'admin']);
            return new RedirectResponse($url);
        }
    }

    public function getDescription(): string
    {
        return 'Admin logout action';
    }
}
