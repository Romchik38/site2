<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\Auth\Admin;

use Laminas\Diactoros\Response\TextResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;

final class DefaultAction extends AbstractMultiLanguageAction
    implements DefaultActionInterface
{
    public function execute(): ResponseInterface
    {
        return new TextResponse('hello');
    }

    public function getDescription(): string
    {
        return 'Admin user auth point';
    }
}