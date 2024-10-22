<?php

declare(strict_types=1);

namespace Romchik38\Site2\Controllers\ServerErrorExample;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;

/** Tries to show nice answer */
class DefaultAction extends MultiLanguageAction implements DefaultActionInterface
{
    public function execute(): string
    {
        throw new \Exception('Example server error occurred');
    }
}
