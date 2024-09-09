<?php

declare(strict_types=1);

namespace Romchik38\Site2\Controllers\Root;

use Romchik38\Server\Api\Controllers\Actions\DynamicActionInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;
use Romchik38\Server\Controllers\Errors\NotFoundException;

class DynamicAction extends MultiLanguageAction implements DynamicActionInterface
{

    protected array $actions = [
        'about' => 'root.about',
        'contacts' => 'root.contacts'
    ];

    public function execute(string $dynamicRoute): string
    {
        $action = $this->actions[$dynamicRoute] ?? null;

        if ($action === null) {
            throw new NotFoundException('action ' . $dynamicRoute . ' not found');
        }

        return $this->translateService->t($action);
    }

    public function getRoutes(): array
    {
        return array_keys($this->actions);
    }
}
