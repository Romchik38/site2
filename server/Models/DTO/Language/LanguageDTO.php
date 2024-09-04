<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\DTO\Language;

use Romchik38\Server\Api\Models\DTO\Language\LanguageDTOInterface;
use Romchik38\Server\Models\DTO;

class LanguageDTO extends DTO implements LanguageDTOInterface
{
    public function __construct(
        protected string $name
    ) {}
    public function getName(): string
    {
        return $this->name;
    }
}
