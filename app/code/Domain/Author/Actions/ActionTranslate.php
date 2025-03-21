<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Author\Actions;

use Romchik38\Site2\Domain\Author\Entities\Translate;

final class ActionTranslate
{
    public function __construct(
        public readonly ActionName $action,
        public readonly Translate $translate
    ) {  
    }
}