<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\New;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Views\ViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Article\ArticleService\Commands\Create;
use Romchik38\Site2\Application\Visitor\VisitorService;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\New\DefaultAction\AuthorFiltersDto;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\New\DefaultAction\ViewDto;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly VisitorService $visitorService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $visitor = $this->visitorService->getVisitor();

        $dto = new ViewDto(
            'Create new article',
            'Create new article page',
            $visitor->getCsrfTokenField(),
            $visitor->getCsrfToken(),
            Create::ID_FIELD,
            Create::AUTHOR_FIELD,
            new AuthorFiltersDto()
        );

        $html = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return 'Admin create new article page ';
    }
}
