<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Category;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Views\ViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Category\List\ListService;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Category\DefaultAction\ViewDTO;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    private const PAGE_NAME_KEY        = 'category.page.name';
    private const PAGE_DESCRIPTION_KEY = 'category.page.description';
    /**
     * category.page.name
     * Article categories
     * Категорії статей
     *
     * category.page.description
     * A page with a list of all categories in which articles are located. Choose the one that interests you and start reading the materials.
     * Сторінка зі списком усіх категорій, в яких знаходяться статті. Оберіть, яка Вас цікавить і перейдіть до читання матеріалів.
     */

    /** @todo usage */
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly ListService $listService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $categories = $this->listService->list($this->getLanguage());

        $translatedPageName        = $this->translateService->t($this::PAGE_NAME_KEY);
        $translatedPageDescription = $this->translateService->t($this::PAGE_DESCRIPTION_KEY);

        $dto = new ViewDTO(
            $translatedPageName,
            $translatedPageDescription,
            $categories
        );

        $result = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($result);
    }

    public function getDescription(): string
    {
        return $this->translateService->t($this::PAGE_NAME_KEY);
    }
}
