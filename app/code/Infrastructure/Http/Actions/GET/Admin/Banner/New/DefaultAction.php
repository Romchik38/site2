<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Banner\New;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Views\ControllerViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Banner\BannerService\Commands\Create;
use Romchik38\Site2\Domain\Banner\VO\Priority;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Banner\New\DefaultAction\ViewDto;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ControllerViewInterface $view
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $dto = new ViewDto(
            'Create new banner',
            'Create new banner page',
            Create::NAME_FIELD,
            Create::PRIORITY_FIELD,
            Create::IMAGE_FIELD,
            Priority::MIN_PRIORITY,
            Priority::MAX_PRIORITY
        );

        $html = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return 'Admin create new banner page ';
    }
}
