<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\ImageService;

use function count;
use function gettype;

final class Create
{
    public const NAME_FIELD                = 'name';
    public const AUTHOR_ID_FIELD           = 'author_id';
    public const TRANSLATES_FIELD          = 'translates';
    public const LANGUAGE_FIELD            = 'language';
    public const DESCRIPTION_FIELD         = 'description';
    public const FILE_FIELD                =  'file';
    public const FOLDER_FIELD              =  'folder';
    public const ALLOWED_FOLDERS           = ['articles', 'common'];

    /** @param array<int,Translate> $translates*/
    private function __construct(
        public readonly string $name,
        public readonly string $authorId,
        public readonly array $translates,
        public readonly mixed $file,
        public readonly string $folder,
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
            $hash[self::AUTHOR_ID_FIELD] ?? '',
            $rawTranslates,
            $hash[self::FILE_FIELD] ?? null,
            $hash[self::FOLDER_FIELD] ?? '',
        );
    }
}
