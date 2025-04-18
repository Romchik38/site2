<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AudioService;

use function is_string;

final class DeleteTranslate
{
    public const AUDIO_ID_FIELD = 'audio_id';
    public const LANGUAGE_FIELD = 'language';

    private function __construct(
        public readonly string $id,
        public readonly string $language,
    ) {
    }

    /** @param array<string,mixed> $hash */
    public static function formHash(array $hash): self
    {
        $id    = '';
        $rawId = $hash[self::AUDIO_ID_FIELD] ?? '';
        if (is_string($rawId)) {
            $id = $rawId;
        }

        $language    = '';
        $rawlanguage = $hash[self::LANGUAGE_FIELD] ?? '';
        if (is_string($rawlanguage)) {
            $language = $rawlanguage;
        }

        return new self(
            $id,
            $language
        );
    }
}
