<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AdminTranslateCreate;

use function is_string;

final class Find
{
    public const ID_FIELD       = 'id';
    public const LANGUAGE_FIELD = 'language';

    public function __construct(
        public readonly string $id,
        public readonly string $language
    ) {
    }

    /** @param array<string,mixed> $hash */
    public static function fromRequest(array $hash): self
    {
        $id    = '';
        $rawId = $hash[self::ID_FIELD] ?? '';
        if (is_string($rawId)) {
            $id = $rawId;
        }

        $language    = '';
        $rawLanguage = $hash[self::LANGUAGE_FIELD] ?? '';
        if (is_string($rawLanguage)) {
            $language = $rawLanguage;
        }

        return new self(
            $id,
            $language
        );
    }
}
