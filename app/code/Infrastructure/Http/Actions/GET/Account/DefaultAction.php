<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Account;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Http\Views\ViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Page\View\Commands\Find\Find;
use Romchik38\Site2\Application\Page\View\CouldNotFindException;
use Romchik38\Site2\Application\Page\View\NoSuchPageException;
use Romchik38\Site2\Application\Page\View\View\PageDto;
use Romchik38\Site2\Application\Page\View\ViewService as PageService;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Account\DefaultAction\ViewDTO;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use RuntimeException;

use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly Site2SessionInterface $session,
        private readonly ViewInterface $view,
        private readonly PageService $pageService,
        private readonly UrlbuilderInterface $urlbuilder,
        private ?PageDto $page = null
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // 1 check if use already logged in
        $user = $this->session->getData(Site2SessionInterface::USER_FIELD);

        // 2. redirect to login page
        $loginUrl = $this->urlbuilder->fromArray(['root', 'login']);
        if ($user === null) {
            return new RedirectResponse($loginUrl);
        }
        // 3. show accaunt
        $page = $this->getPage();

        $dto = new ViewDTO(
            $page->getName(),
            $page->getDescription(),
            $user,
            $page
        );

        $html = $this->view
            ->setController($this->controller)
            ->setControllerData($dto)
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
            $command = new Find('account', $this->getLanguage());
            try {
                $this->page = $this->pageService->find($command);
            } catch (NoSuchPageException) {
                throw new RuntimeException('Account view action error: page with url login not found');
            } catch (CouldNotFindException $e) {
                throw new RuntimeException(sprintf('Account view action error %s: ', $e->getMessage()));
            }
        }

        return $this->page;
    }
}
