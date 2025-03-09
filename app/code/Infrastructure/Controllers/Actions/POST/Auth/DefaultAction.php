<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Auth;

use InvalidArgumentException;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Application\User\UserCheck\CheckPassword;
use Romchik38\Site2\Application\User\UserCheck\InvalidPasswordException;
use Romchik38\Site2\Application\User\UserCheck\UserCheckService;
use Romchik38\Site2\Domain\User\NoSuchUserException;
use Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface;

final class DefaultAction extends AbstractMultiLanguageAction
    implements DefaultActionInterface
{
    /** @todo translate */
    public const string NOT_ACTIVE_MESSAGE_KEY = 'auth.not-active';
    public const string WRONG_PASSWORD_MESSAGE_KEY = 'auth.wrong-password';
    public const string WRONG_USERNAME_MESSAGE_KEY = 'auth.wrong-username';
    public const string SUCCESS_LOGGED_IN = 'auth.success-logged-in';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        protected readonly ServerRequestInterface $request,
        protected readonly UserCheckService $adminUserCheck,
        protected readonly Site2SessionInterface $session,
        protected readonly UrlbuilderInterface $urlbuilder
    )
    {
        parent::__construct($dynamicRootService, $translateService);
    }

    /** @todo replace with form csrf */
    public function execute(): ResponseInterface
    {
        $urlLogin = $this->urlbuilder->fromArray(['root', 'login']);
        // check if user already logged in
        $userField = $this->session->getData(Site2SessionInterface::USER_FIELD);
        if ($userField !== null) {
            if ($userField === '') {
                $this->session->logout();
                return new RedirectResponse($urlLogin);
            }
            return new RedirectResponse($urlLogin);
        }
        // do password check
        $requestData = $this->request->getParsedBody();
        $command = CheckPassword::fromHash($requestData);
        try {
            $email = $this->adminUserCheck->checkPassword($command);
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
        } catch(NoSuchUserException) {
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD, 
                $this::WRONG_USERNAME_MESSAGE_KEY
            );
            return new RedirectResponse($urlLogin);
        }
        $this->session->setData(
            Site2SessionInterface::USER_FIELD, 
            (string) $email
        );
        $this->session->setData(
            Site2SessionInterface::MESSAGE_FIELD, 
            $this::SUCCESS_LOGGED_IN
        );
        return new RedirectResponse($urlLogin);
    }

    public function getDescription(): string
    {
        return 'User auth point';
    }
}
