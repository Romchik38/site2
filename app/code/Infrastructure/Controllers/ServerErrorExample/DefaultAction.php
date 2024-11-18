<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\ServerErrorExample;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;

/** Tries to show nice answer */
final class DefaultAction extends MultiLanguageAction implements DefaultActionInterface
{
    const DEFAULT_VIEW_NAME = 'server-error-example.page_name';

    public function execute(): string
    {
        throw new \Exception('Example server error occurred');
    }

    public function getDescription(): string
    {
        return $this->translateService->t($this::DEFAULT_VIEW_NAME);
    }
}
