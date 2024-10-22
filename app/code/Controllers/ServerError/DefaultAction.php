<?php

declare(strict_types=1);

namespace Romchik38\Site2\Controllers\ServerError;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;

/** Tries to show nice answer */
class DefaultAction extends MultiLanguageAction implements DefaultActionInterface
{

    const DEFAULT_VIEW_NAME = 'Server Error';
    const DEFAULT_VIEW_DESCRIPTION = 'Server error page. Please try again later';

    public function __construct(
        protected readonly DynamicRootInterface $DynamicRootService,
        protected readonly TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        protected readonly DefaultViewDTOFactoryInterface $defaultViewDTOFactory
    ) {}

    public function execute(): string
    {
        /** try to show dynamic view */
        $dto = $this->defaultViewDTOFactory->create(
            $this::DEFAULT_VIEW_NAME,
            $this::DEFAULT_VIEW_DESCRIPTION
        );
        $result = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();
        return $result;
        /** 
         * show static output 
         * @todo implement
         * */

    }
}
