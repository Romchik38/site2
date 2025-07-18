<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AuthorService\Commands;

use function count;
use function gettype;

final class Create
{
    public const NAME_FIELD                = 'name';
    public const CHANGE_ACTIVITY_FIELD     = 'change_activity';
    public const CHANGE_ACTIVITY_YES_FIELD = 'yes';
    public const CHANGE_ACTIVITY_NO_FIELD  = 'no';
    public const TRANSLATES_FIELD          = 'translates';
    public const LANGUAGE_FIELD            = 'language';
    public const DESCRIPTION_FIELD         = 'description';

    /** @param array<int,Translate> $translates*/
    private function __construct(
        public readonly string $name,
        public readonly string $changeActivity,
        public readonly array $translates
    ) {
    }

    /** @param array<string,mixed> $hash */
    public static function formHash(array $hash): self
    {
        $rawTranslates = $hash[self::TRANSLATES_FIELD] ?? [];
        if (gettype($rawTranslates) !== 'array') {
            $rawTranslates = [];
        }
        if (count($rawTranslates) > 0) {
            $translates = [];
            foreach ($rawTranslates as $rawTranslate) {
                $language = $rawTranslate[self::LANGUAGE_FIELD] ?? '';
                if (gettype($language) !== 'string') {
                    $language = '';
                }
                $description = $rawTranslate[self::DESCRIPTION_FIELD] ?? '';
                if (gettype($description) !== 'string') {
                    $description = '';
                }
                $translates[] = new Translate($language, $description);
            }
            $rawTranslates = $translates;
        }

        return new self(
            $hash[self::NAME_FIELD] ?? '',
            $hash[self::CHANGE_ACTIVITY_FIELD] ?? '',
            $rawTranslates
        );
    }
}
