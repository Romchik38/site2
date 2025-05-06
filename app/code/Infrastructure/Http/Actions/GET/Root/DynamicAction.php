<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Root;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DynamicActionInterface;
use Romchik38\Server\Http\Views\Dto\DefaultViewDTOFactoryInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Controllers\Errors\ActionNotFoundException;
use Romchik38\Server\Controllers\Errors\DynamicActionLogicException;
use Romchik38\Server\Models\DTO\DynamicRoute\DynamicRouteDTO;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;

use function sprintf;

final class DynamicAction extends AbstractMultiLanguageAction implements DynamicActionInterface
{
    /** @var array<string,string> $actions */
    private array $actions = [
        'about'    => 'root.about',
        'contacts' => 'root.contacts',
    ];

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly DefaultViewDTOFactoryInterface $defaultViewDtoFactory
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(string $dynamicRoute): ResponseInterface
    {
        $messageKey = $this->actions[$dynamicRoute] ?? null;

        if ($messageKey === null) {
            throw new ActionNotFoundException('action ' . $dynamicRoute . ' not found');
        }

        $translatedMessage = $this->translateService->t($messageKey);

        $dto = $this->defaultViewDtoFactory->create(
            $translatedMessage,
            $translatedMessage
        );

        $result = $this->view
            ->setController($this->getController(), $dynamicRoute)
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($result);
    }

    public function getDynamicRoutes(): array
    {
        $dtos = [];
        foreach ($this->actions as $route => $translateKey) {
            $dtos[] = new DynamicRouteDTO($route, $this->translateService->t($translateKey));
        }
        return $dtos;
    }

    public function getDescription(string $dynamicRoute): string
    {
        $messageKey = $this->actions[$dynamicRoute] ?? null;

        if ($messageKey === null) {
            throw new DynamicActionLogicException(
                sprintf(
                    'Description not found in action %s',
                    $dynamicRoute
                )
            );
        }

        return $this->translateService->t($messageKey);
    }
}
