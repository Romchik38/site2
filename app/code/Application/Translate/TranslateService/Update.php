<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Translate\TranslateService;

use function count;
use function gettype;

final class Update
{
    public const ID_FIELD         = 'id';
    public const TRANSLATES_FIELD = 'translates';
    public const LANGUAGE_FIELD   = 'language';
    public const PHRASE_FIELD     = 'phrase';

    /** @param array<int,Phrase> $phrases*/
    private function __construct(
        public readonly string $id,
        public readonly array $phrases
    ) {
    }

    /** @param array<string,mixed> $hash */
    public static function formHash(array $hash): self
    {
        $rawPhrases = $hash[self::TRANSLATES_FIELD] ?? [];
        if (gettype($rawPhrases) !== 'array') {
            $rawPhrases = [];
        }
        if (count($rawPhrases) > 0) {
            $phrases = [];
            foreach ($rawPhrases as $rawPhrase) {
                $language  = $rawPhrase[self::LANGUAGE_FIELD] ?? '';
                $phrase    = $rawPhrase[self::PHRASE_FIELD] ?? '';
                $phrases[] = new Phrase($language, $phrase);
            }
            $rawPhrases = $phrases;
        }

        return new self(
            $hash[self::ID_FIELD] ?? '',
            $rawPhrases
        );
    }
}
