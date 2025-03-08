<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Login\Admin;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\SessionInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Controllers\Path;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Domain\AdminUser\VO\Password;
use Romchik38\Site2\Domain\AdminUser\VO\Username;
use Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Login\Admin\DefaultAction\ViewDTO;

/** @todo implement it */
final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        protected readonly SessionInterface $session,
        protected readonly ViewInterface $view,
        protected readonly UrlbuilderInterface $urlbuilder
    )
    {
        parent::__construct($dynamicRootService, $translateService);
    }
    
    public function execute(): ResponseInterface
    {
        // 1 check if use already logged in
        $user = $this->session->getData('admin_user');
        $message = (string) $this->session->getData('message');
        if ($message !== '') {
            $this->session->setData('message', '');
        }
        $authUrl = $this->urlbuilder->fromArray(['root', 'auth', 'admin']);
        $html = $this->view
            ->setController($this->controller)
            ->setControllerData(
                new ViewDTO(
                    'Admin user login', 
                    'Admin user login page', 
                    $user,
                    $message,
                    Username::FIELD,
                    Password::FIELD,
                    $authUrl
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