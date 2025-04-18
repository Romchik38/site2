<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AdminTranslateCreate;

use Romchik38\Site2\Domain\Audio\VO\Id as AudioId;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class SearchCriteria
{
    public function __construct(
        public readonly AudioId $audioId,
        public readonly LanguageId $language,
    ) {
    }
}
