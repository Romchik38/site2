<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Root;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Views\ViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Article\List\Commands\Filter\Filter;
use Romchik38\Site2\Application\Article\List\ListService as ArticleListService;
use Romchik38\Site2\Application\Banner\List\Exceptions\NoBannerToDisplayException;
use Romchik38\Site2\Application\Banner\List\Exceptions\PriorityException;
use Romchik38\Site2\Application\Banner\List\ListService as BannerService;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Root\DefaultAction\ViewDTO;

use function array_slice;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    private const DEFAULT_VIEW_NAME = 'root.page_name';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly BannerService $bannerService,
        private readonly LoggerInterface $logger,
        private readonly ArticleListService $articleListService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $translatedMessage = $this->translateService->t($this::DEFAULT_VIEW_NAME);

        // Banner
        $banner = null;
        try {
            $banner = $this->bannerService->priority();
        } catch (PriorityException $e) {
            $this->logger->log(LogLevel::ERROR, $e->getMessage());
        } catch (NoBannerToDisplayException $e) {
            $this->logger->log(LogLevel::INFO, $e->getMessage());
        }

        // Articles
        $command      = new Filter('5', '1', 'created_at', 'desc');
        $filterResult = $this->articleListService->list($command, $this->getLanguage());
        $articleList  = array_slice($filterResult->list, 0, 4);

        $dto = new ViewDTO(
            $translatedMessage,
            $translatedMessage,
            $banner,
            $articleList
        );

        $result = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($result);
    }

    public function getDescription(): string
    {
        return $this->translateService->t($this::DEFAULT_VIEW_NAME);
    }
}
