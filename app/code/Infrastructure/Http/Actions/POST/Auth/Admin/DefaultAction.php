<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Auth\Admin;

use InvalidArgumentException;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\AdminUser\AdminUserService\AdminUserService;
use Romchik38\Site2\Application\AdminUser\AdminUserService\Commands\CheckPassword;
use Romchik38\Site2\Application\AdminUser\AdminUserService\Exceptions\AdminUserNotActiveException;
use Romchik38\Site2\Application\AdminUser\AdminUserService\Exceptions\CouldNotCheckPasswordException;
use Romchik38\Site2\Application\AdminUser\AdminUserService\Exceptions\NoSuchAdminUserException;
use Romchik38\Site2\Application\AdminUser\AdminUserService\InvalidPasswordException;
use Romchik38\Site2\Application\AdminVisitor\AdminVisitorService;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use RuntimeException;

use function gettype;
use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public const NOT_ACTIVE_MESSAGE_KEY        = 'auth.not-active';
    public const WRONG_PASSWORD_MESSAGE_KEY    = 'auth.wrong-password';
    public const WRONG_USERNAME_MESSAGE_KEY    = 'auth.wrong-username';
    public const SUCCESS_LOGGED_IN_KEY         = 'auth.success-logged-in';
    public const BAD_PROVIDED_DATA_MESSAGE_KEY = 'error.during-check-fix-and-try';
    public const SERVER_ERROR_KEY              = 'server-error.message';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly AdminUserService $adminUserCheck,
        private readonly Site2SessionInterface $session,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly LoggerInterface $logger,
        private readonly AdminVisitorService $adminVisitorService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // check password
        $requestData = $request->getParsedBody();
        if (gettype($requestData) !== 'array') {
            throw new RuntimeException('Incoming data is invalid');
        }

        $command  = CheckPassword::fromHash($requestData);
        $urlLogin = $this->urlbuilder->fromArray(['root', 'login', 'admin']);
        try {
            $adminUsername = $this->adminUserCheck->checkPassword($command);
        } catch (AdminUserNotActiveException) {
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD,
                $this->translateService->t($this::NOT_ACTIVE_MESSAGE_KEY)
            );
            return new RedirectResponse($urlLogin);
        } catch (InvalidPasswordException) {
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD,
                $this->translateService->t($this::WRONG_PASSWORD_MESSAGE_KEY)
            );
            return new RedirectResponse($urlLogin);
        } catch (InvalidArgumentException $e) {
            $message = sprintf(
                $this->translateService->t($this::BAD_PROVIDED_DATA_MESSAGE_KEY),
                $e->getMessage()
            );
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD,
                $message
            );
            return new RedirectResponse($urlLogin);
        } catch (NoSuchAdminUserException) {
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD,
                $this->translateService->t($this::WRONG_USERNAME_MESSAGE_KEY)
            );
            return new RedirectResponse($urlLogin);
        } catch (CouldNotCheckPasswordException $e) {
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD,
                $this->translateService->t($this::SERVER_ERROR_KEY)
            );
            $this->logger->error($e->getMessage());
            return new RedirectResponse($urlLogin);
        }

        $this->session->setData(
            Site2SessionInterface::MESSAGE_FIELD,
            $this->translateService->t($this::SUCCESS_LOGGED_IN_KEY)
        );

        $this->adminVisitorService->updateUserName($adminUsername);

        $url = $this->urlbuilder->fromArray(['root', 'admin']);
        return new RedirectResponse($url);
    }

    public function getDescription(): string
    {
        return 'Admin user auth point';
    }
}
