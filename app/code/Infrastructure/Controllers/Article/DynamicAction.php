<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Article;

use Romchik38\Server\Api\Controllers\Actions\DynamicActionInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;
use Romchik38\Server\Controllers\Errors\DynamicActionNotFoundException;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Application\ArticleView\ArticleViewService;
use Romchik38\Site2\Application\ArticleView\Find;
use Romchik38\Site2\Infrastructure\Controllers\Article\DynamicAction\ViewDTO;

final class DynamicAction extends MultiLanguageAction implements DynamicActionInterface
{

    public function __construct(
        protected readonly DynamicRootInterface $DynamicRootService,
        protected readonly TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        /** @todo create Article DTO */
        protected readonly DefaultViewDTOFactoryInterface $defaultViewDTOFactory,
        protected readonly ArticleViewService $articleViewService
    ) {}

    public function execute(string $dynamicRoute): string
    {

        try {
            $article = $this->articleViewService->getArticle(new Find(
                $dynamicRoute,
                $this->getLanguage()
            ));
        } catch (NoSuchEntityException $e) {
            throw new DynamicActionNotFoundException(
                sprintf('Route %s not found. Error message: %s', $dynamicRoute, $e->getMessage())
            );
        }

        /** we pass all checks and can send translate to view */

        $dto = new ViewDTO(
            $article->name,
            $article->shortDescription,
            $article
        );

        $result  = $this->view
            ->setController($this->getController(), $dynamicRoute)
            ->setControllerData($dto)
            ->toString();

        return $result;
    }

    /** @todo implement */
    public function getDynamicRoutes(): array
    {
        return [];
    }

    /** 
     * @todo implement
     * Description of concrete dynamic route 
     * @throws DynamicActionLogicException When description was not found
     */
    public function getDescription(string $dynamicRoute): string
    {
        return 'Article page ' . $dynamicRoute;
    }
}
