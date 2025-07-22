<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Login;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Views\ViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Page\View\Commands\Find\Find;
use Romchik38\Site2\Application\Page\View\CouldNotFindException;
use Romchik38\Site2\Application\Page\View\NoSuchPageException;
use Romchik38\Site2\Application\Page\View\View\PageDto;
use Romchik38\Site2\Application\Page\View\ViewService as PageService;
use Romchik38\Site2\Domain\User\VO\Email;
use Romchik38\Site2\Domain\User\VO\Password;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Login\DefaultAction\ViewDTO;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface;
use RuntimeException;

use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly Site2SessionInterface $session,
        private readonly ViewInterface $view,
        private readonly CsrfTokenGeneratorInterface $csrfTokenGenerator,
        private readonly PageService $pageService,
        private ?PageDto $page = null
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $user = $this->session->getData(Site2SessionInterface::USER_FIELD);

        $csrfToken = $this->csrfTokenGenerator->asBase64();
        $this->session->setData($this->session::CSRF_TOKEN_FIELD, $csrfToken);

        // Page
        $page = $this->getPage();

        $html = $this->view
            ->setController($this->controller)
            ->setControllerData(
                new ViewDTO(
                    $page->getName(),
                    $page->getDescription(),
                    $user,
                    Email::FIELD,
                    Password::FIELD,
                    $this->session::CSRF_TOKEN_FIELD,
                    $csrfToken,
                    $page
                )
            )
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        $page = $this->getPage();
        return $page->getName();
    }

    private function getPage(): PageDto
    {
        if ($this->page === null) {
            $command = new Find('login', $this->getLanguage());
            try {
                $this->page = $this->pageService->find($command);
                return $this->page;
            } catch (NoSuchPageException) {
                throw new RuntimeException('Login view action error: page with url login not found');
            } catch (CouldNotFindException $e) {
                throw new RuntimeException(sprintf('Login view action error %s: ', $e->getMessage()));
            }
        } else {
            return $this->page;
        }
    }
}
