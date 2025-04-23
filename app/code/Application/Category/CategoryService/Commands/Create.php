<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\CategoryService\Commands;

use function count;
use function is_array;
use function is_string;

final class Create
{
    public const CATEGORY_ID_FIELD = 'id';
    public const TRANSLATES_FIELD  = 'translates';
    public const LANGUAGE_FIELD    = 'language';
    public const DESCRIPTION_FIELD = 'description';
    public const NAME_FIELD        = 'name';

    /** @param array<int,Translate> $translates*/
    private function __construct(
        public readonly string $id,
        public readonly array $translates
    ) {
    }

    /** @param array<string,mixed> $hash */
    public static function formHash(array $hash): self
    {
        $id = $hash[self::CATEGORY_ID_FIELD] ?? '';
        if (is_string($id) === false) {
            $id = '';
        }

        $rawTranslates = $hash[self::TRANSLATES_FIELD] ?? [];
        if (is_array($rawTranslates) === false) {
            $rawTranslates = [];
        }
        if (count($rawTranslates) > 0) {
            $translates = [];
            foreach ($rawTranslates as $rawTranslate) {
                $language = $rawTranslate[self::LANGUAGE_FIELD] ?? '';
                if (is_string($language) === false) {
                    $language = '';
                }
                $description = $rawTranslate[self::DESCRIPTION_FIELD] ?? '';
                if (is_string($description) === false) {
                    $description = '';
                }
                $name = $rawTranslate[self::NAME_FIELD] ?? '';
                if (is_string($name) === false) {
                    $name = '';
                }
                $translates[] = new Translate($language, $description, $name);
            }
            $rawTranslates = $translates;
        }

        return new self($id, $rawTranslates);
    }
}
