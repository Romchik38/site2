<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Root;

use InvalidArgumentException;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DynamicActionInterface;
use Romchik38\Server\Http\Controller\Dto\DynamicRouteDTO;
use Romchik38\Server\Http\Controller\Errors\ActionNotFoundException;
use Romchik38\Server\Http\Controller\Errors\DynamicActionLogicException;
use Romchik38\Server\Http\Controller\Name;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Views\ControllerViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Page\View\Commands\Find\Find;
use Romchik38\Site2\Application\Page\View\CouldNotFindException;
use Romchik38\Site2\Application\Page\View\NoSuchPageException;
use Romchik38\Site2\Application\Page\View\ViewService;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Root\DynamicAction\ViewDTO;
use RuntimeException;

use function sprintf;

final class DynamicAction extends AbstractMultiLanguageAction implements DynamicActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ControllerViewInterface $view,
        private readonly ViewService $pageViewService,
        private readonly LoggerInterface $logger
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $decodedRoute = $request->getAttribute(self::TYPE_DYNAMIC_ACTION);
        if (! is_string($decodedRoute)) {
            throw new DynamicActionLogicException('param decodedRoute is invalid');
        }

        $command      = new Find($decodedRoute, $this->getLanguage());

        try {
            $page = $this->pageViewService->find($command);
        } catch (InvalidArgumentException) {
            throw new ActionNotFoundException(sprintf('page %s not found', $decodedRoute));
        } catch (NoSuchPageException) {
            throw new ActionNotFoundException(sprintf('page %s not found', $decodedRoute));
        } catch (CouldNotFindException $e) {
            $this->logger->log(LogLevel::ERROR, $e->getMessage());
            throw new RuntimeException(sprintf('Page view action error %s: ', $e->getMessage()));
        }

        $dto = new ViewDTO(
            $page->getName(),
            $page->getShortDescription(),
            $page
        );

        $result = $this->view
            ->setController($this->getController(), $decodedRoute)
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($result);
    }

    public function getDynamicRoutes(): array
    {
        $dtos = [];
        $list = $this->pageViewService->list($this->getLanguage());
        foreach ($list as $page) {
            $dtos[] = new DynamicRouteDTO(
                $page->getUrl(),
                $page->getName()
            );
        }
        return $dtos;
    }

    public function getDescription(string $dynamicRoute): string
    {
        $command = new Find($dynamicRoute, $this->getLanguage());

        try {
            $page = $this->pageViewService->find($command);
        } catch (InvalidArgumentException) {
            throw new ActionNotFoundException(sprintf('page %s not found', $dynamicRoute));
        } catch (NoSuchPageException) {
            throw new DynamicActionLogicException(sprintf('Description not found in action %s', $dynamicRoute));
        }

        return $page->getName();
    }
}
