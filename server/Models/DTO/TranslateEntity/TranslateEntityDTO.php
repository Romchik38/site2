<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\DTO\TranslateEntity;

use Romchik38\Server\Api\Models\DTO\TranslateEntity\TranslateEntityDTOInterface;
use Romchik38\Server\Models\DTO;

class TranslateEntityDTO extends DTO implements TranslateEntityDTOInterface
{

    public function __construct(
        protected readonly string $key,
        array $data
    ) {
        foreach ($data as $key => $val) {
            $this->data[$key] = $val;
        }
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getPhrase(string $language): string
    {
        return $this->data[$language];
    }
}
