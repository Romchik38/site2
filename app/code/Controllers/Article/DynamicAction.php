<?php

declare(strict_types=1);

namespace Romchik38\Site2\Controllers\Article;

use Romchik38\Server\Api\Controllers\Actions\DynamicActionInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;
use Romchik38\Server\Controllers\Errors\ActionProcessException;
use Romchik38\Server\Controllers\Errors\DynamicActionNotFoundException;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Models\Virtual\Article\Sql\ArticleRepository;

final class DynamicAction extends MultiLanguageAction implements DynamicActionInterface
{

    public function __construct(
        protected readonly DynamicRootInterface $DynamicRootService,
        protected readonly TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        /** @todo create Article DTO */
        protected readonly DefaultViewDTOFactoryInterface $defaultViewDTOFactory,
        /** @todo replace with interface */
        protected readonly ArticleRepository $articleRepository
    ) {}

    public function execute(string $dynamicRoute): string
    {

        try {
            $result = $this->articleRepository->getById($dynamicRoute);
        } catch (NoSuchEntityException $e) {
            throw new DynamicActionNotFoundException(
                sprintf('Route %s not found. Error message: %s', $dynamicRoute, $e->getMessage())
            );
        }

        $translate = $result->getTranslate($this->getLanguage());

        if ($translate === null) {
            /** translate is missig, try to show default language */
            $translate = $result->getTranslate($this->getDefaultLanguage());
            if($translate === null) {
                throw new ActionProcessException(
                    sprintf('Translate for article %s is missing', $dynamicRoute)
                );
            }
        }

        /** we pass all checks and can send translate to view */

        $dto = $this->defaultViewDTOFactory->create(
            $translate->getName(),
            $translate->getShortDescription()
        );

        $result  = $this->view
            ->setController($this->getController(), $dynamicRoute)
            ->setControllerData($dto)
            ->toString();

        return $result;
    }

    /** @todo return routes */
    public function getRoutes(): array
    {
        return [];
    }

    /**
     * @todo move to server 
     * Use to get default language 
     * */
    protected function getDefaultLanguage(): string
    {
        return $this->DynamicRootService->getDefaultRoot()->getName();
    }
}
