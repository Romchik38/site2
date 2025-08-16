<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Register;

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
use Romchik38\Site2\Application\Visitor\VisitorService;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Register\DefaultAction\ViewDTO;
use RuntimeException;

use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    private ?PageDto $page = null;

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ControllerViewInterface $view,
        private readonly PageService $pageService,
        private readonly VisitorService $visitorService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // 1 check if use already logged in
        $visitor = $this->visitorService->getVisitor();

        $page = $this->getPage();

        $dto = new ViewDTO(
            $page->getName(),
            $page->getDescription(),
            $visitor->getUserName(),
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
        return $this->getPage()->getName();
    }

    private function getPage(): PageDto
    {
        if ($this->page === null) {
            $command = new Find('register', $this->getLanguage());
            try {
                $this->page = $this->pageService->find($command);
            } catch (NoSuchPageException) {
                throw new RuntimeException('Register view action error: page with url login not found');
            } catch (CouldNotFindException $e) {
                throw new RuntimeException(sprintf('Register view action error %s: ', $e->getMessage()));
            }
        }

        return $this->page;
    }
}
