<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Login\Admin;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Http\Views\ViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\AdminUser\AdminUserService\Commands\CheckPassword;
use Romchik38\Site2\Application\Visitor\VisitorService;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Login\Admin\DefaultAction\ViewDTO;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly VisitorService $visitorService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $visitor  = $this->visitorService->getVisitor();
        $username = $visitor->getUserName();
        if ($username === null) {
            $user = null;
        } else {
            $user = $username;
        }

        $authUrl = $this->urlbuilder->fromArray(['root', 'auth', 'admin']);
        $html    = $this->view
            ->setController($this->controller)
            ->setControllerData(
                new ViewDTO(
                    'Admin user login',
                    'Admin user login page',
                    $user,
                    CheckPassword::USERNAME_FIELD,
                    CheckPassword::PASSWORD_FIELD,
                    $authUrl,
                    $visitor->getCsrfTokenField(),
                    $visitor->getCsrfToken()
                )
            )
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return 'Admin user login page';
    }
}
