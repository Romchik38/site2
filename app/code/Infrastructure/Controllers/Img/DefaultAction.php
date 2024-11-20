<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Img;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Controllers\Actions\Action;

final class DefaultAction extends Action implements DefaultActionInterface
{
    public function execute(): string
    {
        return json_encode($_SERVER);
    }

    public function getDescription(): string
    {
        return 'Images';
    }
}
