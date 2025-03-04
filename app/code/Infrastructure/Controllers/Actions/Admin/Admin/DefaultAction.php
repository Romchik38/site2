<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\Admin\Admin;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractAction;
use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;

final class DefaultAction extends AbstractAction implements DefaultActionInterface
{
    public function __construct(
        protected readonly ViewInterface $view
    ) {
    }

    public function execute(): ResponseInterface
    {
        $dto = new DefaultViewDTO('Admin', 'Admin page');
        $html = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();
        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return 'Admin panel';
    }
}