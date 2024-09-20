<?php

declare(strict_types=1);

namespace Romchik38\Site2\Controllers\Root;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;

class DefaultAction extends MultiLanguageAction implements DefaultActionInterface
{

    public function __construct(
        protected readonly DynamicRootInterface $DynamicRootService,
        protected readonly TranslateInterface $translateService,
        protected readonly ViewInterface $view
    ) {}

    public function execute(): string
    {
        

        return 'home';
    }
}
