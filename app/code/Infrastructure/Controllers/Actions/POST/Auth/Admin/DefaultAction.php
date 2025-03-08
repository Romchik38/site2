<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Auth\Admin;

use InvalidArgumentException;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\Response\TextResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\SessionInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Application\AdminUserCheck\AdminUserCheckService;
use Romchik38\Site2\Application\AdminUserCheck\AdminUserNotActiveException;
use Romchik38\Site2\Application\AdminUserCheck\CheckPassword;
use Romchik38\Site2\Application\AdminUserCheck\InvalidPasswordException;
use Romchik38\Site2\Domain\AdminUser\NoSuchAdminUserException;

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
        protected readonly SessionInterface $session,
        protected readonly UrlbuilderInterface $urlbuilder
    )
    {
        parent::__construct($dynamicRootService, $translateService);
    }

    /** 
     * @todo check all exrrors
     * @todo do redirect to login page with message on error
     */
    public function execute(): ResponseInterface
    {
        /** @todo replace with form csrf */
        $requestData = $this->request->getParsedBody();
        $command = CheckPassword::fromHash($requestData);
        try {
            $adminUsername = $this->adminUserCheck->checkPassword($command);
        } catch(AdminUserNotActiveException) {
            $this->session->setData('message', $this::NOT_ACTIVE_MESSAGE_KEY);
            return new TextResponse($this::NOT_ACTIVE_MESSAGE_KEY);
        } catch(InvalidPasswordException) {
            $this->session->setData('message', $this::WRONG_PASSWORD_MESSAGE_KEY);
            return new TextResponse($this::WRONG_PASSWORD_MESSAGE_KEY);
        } catch(InvalidArgumentException $e) {
            /** @todo translate */
            $message = sprintf(
                'Error during check: %s. Please fix it and try again',
                $e->getMessage()
            );
            $this->session->setData('message', $message);
            return new TextResponse($message);
        } catch(NoSuchAdminUserException) {
            $this->session->setData('message', $this::WRONG_USERNAME_MESSAGE_KEY);
            return new TextResponse($this::WRONG_USERNAME_MESSAGE_KEY);
        }
        $this->session->setData('message', $this::SUCCESS_LOGGED_IN);
        $this->session->setData('admin_user', (string) $adminUsername());
        $url = $this->urlbuilder->fromArray(['root', 'admin']);
        return new RedirectResponse($url);
    }

    public function getDescription(): string
    {
        return 'Admin user auth point';
    }
}