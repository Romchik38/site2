<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Admin;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Controllers\Actions\Action;

final class DefaultAction extends Action implements DefaultActionInterface{
    public function execute(): ResponseInterface
    {
        return new HtmlResponse('Wellcome to admin panel');
    }

    public function getDescription(): string
    {
        return 'Admin panel';
    }
}