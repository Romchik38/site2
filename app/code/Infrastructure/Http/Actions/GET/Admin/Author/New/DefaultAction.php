<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author\New;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Views\ControllerViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Author\AuthorService\Commands\Create;
use Romchik38\Site2\Application\Language\List\ListService;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author\New\DefaultAction\ViewDto;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ControllerViewInterface $view,
        private readonly ListService $languageService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $languages = $this->languageService->getAll();

        $dto = new ViewDto(
            'Author create new',
            'Authors create new page',
            Create::NAME_FIELD,
            Create::CHANGE_ACTIVITY_FIELD,
            Create::CHANGE_ACTIVITY_YES_FIELD,
            Create::CHANGE_ACTIVITY_NO_FIELD,
            Create::TRANSLATES_FIELD,
            Create::LANGUAGE_FIELD,
            Create::DESCRIPTION_FIELD,
            $languages
        );

        $html = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return 'Admin Author create new page ';
    }
}
