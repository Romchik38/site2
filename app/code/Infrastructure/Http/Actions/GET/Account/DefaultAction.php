<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Account;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Http\Views\ViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Article\ContinueReading\Commands\Find\Find as ContinueReadingFind;
use Romchik38\Site2\Application\Article\ContinueReading\ContinueReading;
use Romchik38\Site2\Application\Page\View\Commands\Find\Find;
use Romchik38\Site2\Application\Page\View\CouldNotFindException;
use Romchik38\Site2\Application\Page\View\NoSuchPageException;
use Romchik38\Site2\Application\Page\View\View\PageDto;
use Romchik38\Site2\Application\Page\View\ViewService as PageService;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Account\DefaultAction\ViewDTO;
use Romchik38\Site2\Infrastructure\Http\Actions\POST\Api\ArticleContinueReading\DefaultAction\Item;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use RuntimeException;

use function sprintf;
use function unserialize;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly Site2SessionInterface $session,
        private readonly ViewInterface $view,
        private readonly PageService $pageService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly ContinueReading $continueReadingService,
        private readonly LoggerInterface $logger,
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

        // 4. continue reading
        $continueReadingArtricle = null;
        $sessionItemData         = $this->session->getData(Site2SessionInterface::ARTICLE_LAST_VISITED);
        if ($sessionItemData !== null && $sessionItemData !== '') {
            $item = unserialize($sessionItemData);
            if (! $item instanceof Item) {
                throw new RuntimeException('Session article data is invalid');
            }
            $command = new ContinueReadingFind($item->first, $this->getLanguage());
            try {
                $continueReadingArtricle = $this->continueReadingService->find($command);
            } catch (RuntimeException $e) {
                $this->logger->error('Account action:' . $e->getMessage());
            }
        }

        $dto = new ViewDTO(
            $page->getName(),
            $page->getDescription(),
            $user,
            $page,
            $continueReadingArtricle
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
