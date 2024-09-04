<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\DTO\Language;

interface LanguageDTOFactoryInterface
{
    public function create(string $name): LanguageDTOInterface;
}
