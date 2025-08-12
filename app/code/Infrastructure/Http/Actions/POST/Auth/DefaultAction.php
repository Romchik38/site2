<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Auth;

use InvalidArgumentException;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\User\UserCheck\CheckPassword;
use Romchik38\Site2\Application\User\UserCheck\InvalidPasswordException;
use Romchik38\Site2\Application\User\UserCheck\UserCheckService;
use Romchik38\Site2\Application\Visitor\VisitorService;
use Romchik38\Site2\Domain\User\NoSuchUserException;
use RuntimeException;

use function gettype;
use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    private const string WRONG_PASSWORD_MESSAGE_KEY    = 'auth.wrong-password';
    private const string WRONG_USERNAME_MESSAGE_KEY    = 'auth.wrong-username';
    private const string SUCCESS_LOGGED_IN             = 'auth.success-logged-in';
    private const string BAD_PROVIDED_DATA_MESSAGE_KEY = 'error.during-check-fix-and-try';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly UserCheckService $adminUserCheck,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly VisitorService $visitorService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $urlLogin   = $this->urlbuilder->fromArray(['root', 'login']);
        $urlAccount = $this->urlbuilder->fromArray(['root', 'account']);
        // visitor
        $visitor = $this->visitorService->getVisitor();
        // check if user already logged in
        if ($visitor->username !== null) {
            return new RedirectResponse($urlLogin);
        }
        // do password check
        $requestData = $request->getParsedBody();
        if (gettype($requestData) !== 'array') {
            throw new RuntimeException('Incoming data is invalid');
        }

        $command = CheckPassword::fromHash($requestData);
        try {
            $username = $this->adminUserCheck->checkPassword($command);
        } catch (InvalidPasswordException) {
            $this->visitorService->changeMessage($this->translateService->t($this::WRONG_PASSWORD_MESSAGE_KEY));
            return new RedirectResponse($urlLogin);
        } catch (InvalidArgumentException $e) {
            $message = sprintf(
                $this->translateService->t($this::BAD_PROVIDED_DATA_MESSAGE_KEY),
                $this->translateService->t($e->getMessage())
            );
            $this->visitorService->changeMessage($message);
            return new RedirectResponse($urlLogin);
        } catch (NoSuchUserException) {
            $this->visitorService->changeMessage($this->translateService->t($this::WRONG_USERNAME_MESSAGE_KEY));
            return new RedirectResponse($urlLogin);
        }

        $this->visitorService->updateUserName($username);
        $this->visitorService->changeMessage($this->translateService->t($this::SUCCESS_LOGGED_IN));

        return new RedirectResponse($urlAccount);
    }

    public function getDescription(): string
    {
        return 'User auth point';
    }
}
