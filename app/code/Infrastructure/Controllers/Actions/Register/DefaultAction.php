<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\Register;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\SessionInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Site2\Infrastructure\Controllers\Actions\Register\DefaultAction\ViewDTO;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        protected readonly SessionInterface $session,
        protected readonly ViewInterface $view
    )
    {
        parent::__construct($dynamicRootService, $translateService);
    }
    
    public function execute(): ResponseInterface
    {
        // 1 check if use already logged in
        $adminUser = $this->session->getData('user');
        $html = $this->view
            ->setController($this->controller)
            ->setControllerData(
                new ViewDTO('User register', 'User register page', $adminUser)
            )
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return 'Registration page';
    }
}