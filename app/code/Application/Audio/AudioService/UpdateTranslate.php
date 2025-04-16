<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AudioService;

use function is_string;

final class UpdateTranslate
{
    public const ID_FIELD          = 'id';
    public const LANGUAGE_FIELD    = 'language';
    public const DESCRIPTION_FIELD = 'description';

    private function __construct(
        public readonly string $id,
        public readonly string $language,
        public readonly string $description,
    ) {
    }

    /** @param array<string,mixed> $hash */
    public static function formHash(array $hash): self
    {
        $id    = '';
        $rawId = $hash[self::ID_FIELD] ?? '';
        if (is_string($rawId)) {
            $id = $rawId;
        }

        $language    = '';
        $rawlanguage = $hash[self::LANGUAGE_FIELD] ?? '';
        if (is_string($rawlanguage)) {
            $language = $rawlanguage;
        }

        $description    = '';
        $rawDescription = $hash[self::DESCRIPTION_FIELD] ?? '';
        if (is_string($rawDescription)) {
            $description = $rawDescription;
        }

        return new self($id, $language, $description);
    }
}
