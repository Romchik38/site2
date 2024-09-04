<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\DTO\Language;

use Romchik38\Server\Services\Language\LanguageInterface;

/** language entity */
interface LanguageDTOInterface
{
    public function getName(): string;
}
