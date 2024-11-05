<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Root;

use Romchik38\Server\Api\Controllers\Actions\DynamicActionInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;
use Romchik38\Server\Controllers\Errors\DynamicActionNotFoundException;

final class DynamicAction extends MultiLanguageAction implements DynamicActionInterface
{

    /**
     * @var array<string,string> $actions
     */
    protected array $actions = [
        'about' => 'root.about',
        'contacts' => 'root.contacts'
    ];

    public function __construct(
        protected readonly DynamicRootInterface $DynamicRootService,
        protected readonly TranslateInterface $translateService,
        protected readonly ViewInterface $view,
        protected readonly DefaultViewDTOFactoryInterface $defaultViewDTOFactory
    ) {}

    public function execute(string $dynamicRoute): string
    {
        $messageKey = $this->actions[$dynamicRoute] ?? null;

        if ($messageKey === null) {
            throw new DynamicActionNotFoundException('action ' . $dynamicRoute . ' not found');
        }

        $translatedMessage = $this->translateService->t($messageKey);

        $dto = $this->defaultViewDTOFactory->create(
            $translatedMessage,
            $translatedMessage
        );

        $result  = $this->view
            ->setController($this->getController(), $dynamicRoute)
            ->setControllerData($dto)
            ->toString();

        return $result;
    }

    public function getRoutes(): array
    {
        return array_keys($this->actions);
    }
}
