<?php

declare(strict_types=1);

namespace Romchik38\Server\Services\Translate;

use Romchik38\Server\Api\Models\DTO\TranslateEntity\TranslateEntityDTOInterface;

interface TranslateStorageInterface
{

    /**
     * get all dto entities by provided languages
     * 
     * @param string[] $languages ['en', ...]
     * @return TranslateEntityDTOInterface[] list of translate dto entities
     */
    public function getDataByLanguages(array $languages): array;
}
