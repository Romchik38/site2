<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Login;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Views\ControllerViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Page\View\Commands\Find\Find;
use Romchik38\Site2\Application\Page\View\CouldNotFindException;
use Romchik38\Site2\Application\Page\View\NoSuchPageException;
use Romchik38\Site2\Application\Page\View\View\PageDto;
use Romchik38\Site2\Application\Page\View\ViewService as PageService;
use Romchik38\Site2\Application\User\UserCheck\CheckPassword;
use Romchik38\Site2\Application\Visitor\VisitorService;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Login\DefaultAction\ViewDTO;
use RuntimeException;

use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ControllerViewInterface $view,
        private readonly PageService $pageService,
        private readonly VisitorService $visitorService,
        private ?PageDto $page = null
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $visitor = $this->visitorService->getVisitor();
        if ($visitor->username === null) {
            $user = $visitor->username;
        } else {
            $user = ($visitor->username)();
        }

        $page = $this->getPage();

        $html = $this->view
            ->setController($this->controller)
            ->setControllerData(
                new ViewDTO(
                    $page->getName(),
                    $page->getDescription(),
                    $user,
                    CheckPassword::EMAIL_FIELD,
                    CheckPassword::PASSWORD_FIELD,
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
