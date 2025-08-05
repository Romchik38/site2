<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Article\MostVisited\Clear;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Article\ArticleService\ArticleService;
use Romchik38\Site2\Application\Article\ArticleService\Exceptions\RepositoryException;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    private const string SUCCESS_DELETE_KEY   = 'admin.data-success-delete';
    private const string COULD_NOT_DELETE_KEY = 'admin.could-not-delete';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly Site2SessionInterface $session,
        private readonly LoggerInterface $logger,
        private readonly ArticleService $articleService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $uri     = $this->urlbuilder->fromArray(['root', 'admin', 'article', 'most_visited']);
        $message = '';

        try {
            $this->articleService->clearViews();
            $message = $this->translateService->t($this::SUCCESS_DELETE_KEY);
        } catch (RepositoryException $e) {
            $message = $this->translateService->t($this::COULD_NOT_DELETE_KEY);
            $this->logger->log(LogLevel::ERROR, $e->getMessage());
        }

        // Common answer
        if ($message !== '') {
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD,
                $message
            );
        }
        return new RedirectResponse($uri);
    }

    public function getDescription(): string
    {
        return 'Admin Article most visited clear point';
    }
}
