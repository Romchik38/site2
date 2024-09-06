<?php

declare(strict_types=1);

namespace Romchik38\Site2\Controllers\ServerError;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Controllers\Actions\Action;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;

class DefaultAction extends MultiLanguageAction implements DefaultActionInterface {
    public function execute(): string
    {
        return $this->translateService->t('server-error.message');
    }
}