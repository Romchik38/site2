<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Login;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Views\ViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Domain\User\VO\Email;
use Romchik38\Site2\Domain\User\VO\Password;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Login\DefaultAction\ViewDTO;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly Site2SessionInterface $session,
        private readonly ViewInterface $view,
        private readonly CsrfTokenGeneratorInterface $csrfTokenGenerator
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(): ResponseInterface
    {
        $user = $this->session->getData(Site2SessionInterface::USER_FIELD);

        $csrfToken = $this->csrfTokenGenerator->asBase64();
        $this->session->setData($this->session::CSRF_TOKEN_FIELD, $csrfToken);

        $html = $this->view
            ->setController($this->controller)
            ->setControllerData(
                new ViewDTO(
                    'User login',
                    'User login page',
                    $user,
                    Email::FIELD,
                    Password::FIELD,
                    $this->session::CSRF_TOKEN_FIELD,
                    $csrfToken
                )
            )
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return 'User login page';
    }
}
