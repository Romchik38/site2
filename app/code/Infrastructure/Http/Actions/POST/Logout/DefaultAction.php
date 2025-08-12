<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Logout;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Visitor\VisitorService;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    private const LOGOUT_MESSAGE_KEY = 'logout.you-must-login-first';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly VisitorService $visitorService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $visitor  = $this->visitorService->getVisitor();
        $urlLogin = $this->urlbuilder->fromArray(['root', 'login']);
        if ($visitor->username !== null) {
            $this->visitorService->logout();
            return new RedirectResponse($urlLogin);
        }
        $this->visitorService->changeMessage($this->translateService->t($this::LOGOUT_MESSAGE_KEY));

        return new RedirectResponse($urlLogin);
    }

    public function getDescription(): string
    {
        return 'Logout action point';
    }
}
