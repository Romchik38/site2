<?php

namespace Romchik38\Server\Api\Models\DTO\TranslateEntity;

use Romchik38\Server\Api\Models\DTO\DTOInterface;

interface TranslateEntityDTOInterface extends DTOInterface
{
    /** returns translate key */
    public function getKey(): string;

    /** 
     * returns text phrase by provided language
     */
    public function getPhrase(string $language): string;
}
