<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AdminTranslateView\View;

use Romchik38\Site2\Domain\Audio\VO\Description;
use Romchik38\Site2\Domain\Audio\VO\Id as AudioId;
use Romchik38\Site2\Domain\Audio\VO\Path;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class TranslateDto
{
    public function __construct(
        public readonly AudioId $audioId,
        public readonly LanguageId $language,
        public readonly Description $description,
        public readonly Path $path
    ) {
    }
}
