<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Logout;

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
    protected const LOGOUT_MESSAGE_KEY = 'logout.you-must-login-first';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        protected readonly UrlbuilderInterface $urlbuilder,
        protected readonly Site2SessionInterface $session
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(): ResponseInterface
    {
        $user = $this->session->getData(Site2SessionInterface::USER_FIELD);
        $urlLogin = $this->urlbuilder->fromArray(['root', 'login']);
        if ($user !== null) {
            $this->session->logout();
            return new RedirectResponse($urlLogin);
        }
        $this->session->setData(
            Site2SessionInterface::MESSAGE_FIELD, 
            $this->translateService->t($this::LOGOUT_MESSAGE_KEY)
        );
    
        return new RedirectResponse($urlLogin);
    }

    public function getDescription(): string
    {
        return 'Logout action point';
    }
}
