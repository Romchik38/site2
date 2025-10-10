<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\CommercialOffer;

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
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Contacts\DefaultAction\ViewDTO;
use RuntimeException;

use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ControllerViewInterface $view,
        private readonly PageService $pageService,
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $page = $this->getPage();

        $dto = new ViewDTO(
            $page->getName(),
            $page->getShortDescription(),
            $page,
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
        $command = new Find('commercial-offer', $this->getLanguage());
        try {
            return $this->pageService->find($command);
        } catch (NoSuchPageException) {
            throw new RuntimeException('Commercial offer view action error: page with url login not found');
        } catch (CouldNotFindException $e) {
            throw new RuntimeException(sprintf('Commercial offer view action error %s: ', $e->getMessage()));
        }
    }
}
