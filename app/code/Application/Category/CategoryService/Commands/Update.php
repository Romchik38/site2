<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\CategoryService\Commands;

use function count;
use function is_array;
use function is_string;

final class Update
{
    public const ID_FIELD                  = 'id';
    public const TRANSLATES_FIELD          = 'translates';
    public const LANGUAGE_FIELD            = 'language';
    public const NAME_FIELD                = 'name';
    public const DESCRIPTION_FIELD         = 'description';
    public const CHANGE_ACTIVITY_FIELD     = 'change_activity';
    public const CHANGE_ACTIVITY_YES_FIELD = 'yes';
    public const CHANGE_ACTIVITY_NO_FIELD  = 'no';

    /** @param array<int,Translate> $translates */
    private function __construct(
        public readonly string $id,
        public readonly string $changeActivity,
        public readonly array $translates
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

        $changeActivity    = '';
        $rawChangeActivity = $hash[self::CHANGE_ACTIVITY_FIELD] ?? '';
        if (is_string($rawChangeActivity)) {
            $changeActivity = $rawChangeActivity;
        }

        $rawTranslates = $hash[self::TRANSLATES_FIELD] ?? [];
        if (is_array($rawTranslates) === false) {
            $rawTranslates = [];
        }
        if (count($rawTranslates) > 0) {
            $translates = [];
            foreach ($rawTranslates as $rawTranslate) {
                $language     = $rawTranslate[self::LANGUAGE_FIELD] ?? '';
                $name         = $rawTranslate[self::NAME_FIELD] ?? '';
                $description  = $rawTranslate[self::DESCRIPTION_FIELD] ?? '';
                $translates[] = new Translate($language, $description, $name);
            }
            $rawTranslates = $translates;
        }

        return new self($id, $changeActivity, $rawTranslates);
    }
}
