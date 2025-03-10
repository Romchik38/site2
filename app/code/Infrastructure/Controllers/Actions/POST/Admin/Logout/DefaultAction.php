<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Logout;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface;

final class DefaultAction extends AbstractMultiLanguageAction
    implements DefaultActionInterface
{
    protected const LOGOUT_MESSAGE_KEY = 'admin.logout.you-must-login-first';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        protected readonly UrlbuilderInterface $urlbuilder,
        protected readonly Site2SessionInterface $session
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(): ResponseInterface {
        $user = $this->session->getData(Site2SessionInterface::ADMIN_USER_FIELD);
        if ($user !== null) {
            $this->session->logout();
            $url = $this->urlbuilder->fromArray(['root', 'login', 'admin']);
            return new RedirectResponse($url);
        }
        $this->session->setData(
            Site2SessionInterface::MESSAGE_FIELD, 
            $this::LOGOUT_MESSAGE_KEY
        );
        $url = $this->urlbuilder->fromArray(['root', 'login', 'admin']);
        return new RedirectResponse($url);
    }

    public function getDescription(): string
    {
        return 'Admin logout action';
    }
}
