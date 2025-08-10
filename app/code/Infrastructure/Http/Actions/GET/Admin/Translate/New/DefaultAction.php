<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Translate\New;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Views\ViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\AdminVisitor\AdminVisitorService;
use Romchik38\Site2\Application\Language\List\ListService;
use Romchik38\Site2\Application\Translate\TranslateService\Update;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Translate\New\DefaultAction\ViewDto;

use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly ListService $languageService,
        private readonly AdminVisitorService $adminVisitorService,
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $languages = $this->languageService->getAll();

        $visitor = $this->adminVisitorService->getVisitor();

        $dto = new ViewDto(
            sprintf('Translate create new'),
            sprintf('Translate create new page'),
            $visitor->getCsrfTokenField(),
            $visitor->getCsrfToken(),
            Update::ID_FIELD,
            Update::TRANSLATES_FIELD,
            Update::LANGUAGE_FIELD,
            Update::PHRASE_FIELD,
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
        return 'Admin Translate create new ';
    }
}
