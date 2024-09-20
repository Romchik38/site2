<?php

declare(strict_types=1);

namespace Romchik38\Site2\Controllers\Root;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;

class DefaultAction extends MultiLanguageAction implements DefaultActionInterface
{

    public function __construct(
        protected readonly DynamicRootInterface $DynamicRootService,
        protected readonly TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        protected readonly DefaultViewDTOFactoryInterface $defaultViewDTOFactory
    ) {}

    public function execute(): string
    {

        $messageKey = 'root.page_name';
        $translatedMessage = $this->translateService->t($messageKey);

        $dto = $this->defaultViewDTOFactory->create(
            $translatedMessage . ' Title',
            $translatedMessage . ' Description',
            $translatedMessage . ' Page'
        );

        $result  = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return 'home';
    }
}
