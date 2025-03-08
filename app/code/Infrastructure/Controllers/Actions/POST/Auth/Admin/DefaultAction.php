<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Auth\Admin;

use InvalidArgumentException;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Application\AdminUserCheck\AdminUserCheckService;
use Romchik38\Site2\Application\AdminUserCheck\CheckPassword;
use Romchik38\Site2\Application\AdminUserCheck\InvalidPasswordException;
use Romchik38\Site2\Domain\AdminUser\AdminUserNotActiveException;
use Romchik38\Site2\Domain\AdminUser\NoSuchAdminUserException;
use Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface;

final class DefaultAction extends AbstractMultiLanguageAction
    implements DefaultActionInterface
{
    /** @todo translate */
    public const string NOT_ACTIVE_MESSAGE_KEY = 'auth.admin.not-active';
    public const string WRONG_PASSWORD_MESSAGE_KEY = 'auth.admin.wrong-password';
    public const string WRONG_USERNAME_MESSAGE_KEY = 'auth.admin.wrong-username';
    public const string SUCCESS_LOGGED_IN = 'auth.admin.success-logged-in';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        protected readonly ServerRequestInterface $request,
        protected readonly AdminUserCheckService $adminUserCheck,
        protected readonly Site2SessionInterface $session,
        protected readonly UrlbuilderInterface $urlbuilder
    )
    {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(): ResponseInterface
    {
        /** @todo replace with form csrf */
        $requestData = $this->request->getParsedBody();
        $command = CheckPassword::fromHash($requestData);
        $urlLogin = $this->urlbuilder->fromArray(['root', 'login', 'admin']);
        try {
            $adminUsername = $this->adminUserCheck->checkPassword($command);
        } catch(AdminUserNotActiveException) {
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD, 
                $this::NOT_ACTIVE_MESSAGE_KEY
            );
            return new RedirectResponse($urlLogin);
        } catch(InvalidPasswordException) {
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD, 
                $this::WRONG_PASSWORD_MESSAGE_KEY
            );
            return new RedirectResponse($urlLogin);
        } catch(InvalidArgumentException $e) {
            /** @todo translate */
            $message = sprintf(
                'Error during check: %s. Please fix it and try again',
                $e->getMessage()
            );
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD, 
                $message
            );
            return new RedirectResponse($urlLogin);
        } catch(NoSuchAdminUserException) {
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD, 
                $this::WRONG_USERNAME_MESSAGE_KEY
            );
            return new RedirectResponse($urlLogin);
        }
        $this->session->setData(
            Site2SessionInterface::MESSAGE_FIELD, 
            $this::SUCCESS_LOGGED_IN
        );
        $this->session->setData(
            Site2SessionInterface::ADMIN_USER_FIELD, 
            (string) $adminUsername()
        );
        $url = $this->urlbuilder->fromArray(['root', 'admin']);
        return new RedirectResponse($url);
    }

    public function getDescription(): string
    {
        return 'Admin user auth point';
    }
}
