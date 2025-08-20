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
use Romchik38\Server\Http\Views\ControllerViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Article\ContinueReading\ContinueReading;
use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\CouldNotListException;
use Romchik38\Site2\Application\Page\View\Commands\Find\Find;
use Romchik38\Site2\Application\Page\View\CouldNotFindException;
use Romchik38\Site2\Application\Page\View\NoSuchPageException;
use Romchik38\Site2\Application\Page\View\View\PageDto;
use Romchik38\Site2\Application\Page\View\ViewService as PageService;
use Romchik38\Site2\Application\Visitor\VisitorService;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Account\DefaultAction\ViewDTO;
use RuntimeException;

use function count;
use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ControllerViewInterface $view,
        private readonly PageService $pageService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly ContinueReading $continueReadingService,
        private readonly LoggerInterface $logger,
        private readonly VisitorService $visitorService,
        private ?PageDto $page = null
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $user = null;
        // 1 check if use already logged in
        $visitor = $this->visitorService->getVisitor();
        // 2. redirect to login page
        $loginUrl = $this->urlbuilder->fromArray(['root', 'login']);
        if ($visitor->username === null) {
            return new RedirectResponse($loginUrl);
        } else {
            $user = ($visitor->username)();
        }
        // 3. show accaunt
        $page = $this->getPage();

        // 4. continue reading
        $article = null;
        try {
            $articles = $this->continueReadingService->list($this->getLanguage());
            if (count($articles) > 0) {
                $article = $articles[0];
            }
        } catch (CouldNotListException $e) {
            $this->logger->error($e->getMessage());
        }

        $dto = new ViewDTO(
            $page->getName(),
            $page->getShortDescription(),
            $user,
            $page,
            $article
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
