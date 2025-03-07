<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Logout;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\SessionInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface;

final class DefaultAction extends AbstractMultiLanguageAction
    implements DefaultActionInterface
{
    protected const LOGIN_MESSAGE_KEY = 'admin.logout.you-must-login-first';
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        protected readonly UrlbuilderInterface $urlbuilder,
        protected readonly SessionInterface $session
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    /** @todo csrf */
    public function execute(): ResponseInterface {
        $user = $this->session->getData('admin_user');
        if ($user !== null) {
            $this->session->logout();
            $url = $this->urlbuilder->fromArray(['root', 'login', 'admin']);
            return new RedirectResponse($url);
        }
        $this->session->setData('message', $this::LOGIN_MESSAGE_KEY);
        $url = $this->urlbuilder->fromArray(['root', 'login', 'admin']);
        return new RedirectResponse($url);
    }

    public function getDescription(): string
    {
        return 'Admin logout action';
    }
}
