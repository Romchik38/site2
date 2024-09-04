<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\DTO\Language;

use Romchik38\Server\Api\Models\DTO\Language\LanguageDTOFactoryInterface;
use Romchik38\Server\Api\Models\DTO\Language\LanguageDTOInterface;

class LanguageDTOFactory implements LanguageDTOFactoryInterface
{
    public function create(string $name): LanguageDTOInterface
    {
        return new LanguageDTO($name);
    }
}
