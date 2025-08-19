<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\MostVisited;

use InvalidArgumentException;
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
use Romchik38\Site2\Application\AdminVisitor\AdminVisitorService;
use Romchik38\Site2\Application\Article\AdminMostVisited\AdminMostVisited;
use Romchik38\Site2\Application\Article\AdminMostVisited\Exceptions\CouldNotListException;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\MostVisited\DefaultAction\ViewDto;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public const SERVER_ERROR       = 'server-error.message';
    public const ACTION_DESCRIPTION = 'Admin article most visited page';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ControllerViewInterface $view,
        private readonly AdminMostVisited $adminMostVisitedService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly LoggerInterface $logger,
        private readonly AdminVisitorService $adminVisitorService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $uriRedirect        = $this->urlbuilder->fromArray(['root', 'admin']);
        $serverErrorMessage = $this->translateService->t($this::SERVER_ERROR);

        try {
            $articleList = $this->adminMostVisitedService->list($this->getLanguage());
        } catch (CouldNotListException $e) {
            $this->logger->error($e->getMessage());
            $this->adminVisitorService->changeMessage($serverErrorMessage);
            return new RedirectResponse($uriRedirect);
        } catch (InvalidArgumentException $e) {
            $this->logger->error($e->getMessage());
            $this->adminVisitorService->changeMessage($serverErrorMessage);
            return new RedirectResponse($uriRedirect);
        }

        $dto  = new ViewDto(
            'Admin article most visited',
            self::ACTION_DESCRIPTION,
            $articleList
        );
        $html = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();
        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return self::ACTION_DESCRIPTION;
    }
}
