<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ArticleService\Commands;

use Romchik38\Site2\Application\Article\ArticleService\Commands\Translate;

use function count;
use function is_array;
use function is_string;

final class Update
{
    public const ID_FIELD                  = 'id';
    public const CHANGE_ACTIVITY_FIELD     = 'change_activity';
    public const CHANGE_ACTIVITY_YES_FIELD = 'yes';
    public const CHANGE_ACTIVITY_NO_FIELD  = 'no';
    public const TRANSLATES_FIELD          = 'translates';
    public const LANGUAGE_FIELD            = 'language';
    public const NAME_FIELD                = 'name';
    public const SHORT_DESCRIPTION_FIELD   = 'short_description';
    public const DESCRIPTION_FIELD         = 'description';
    public const AUDIO_FIELD               = 'audio_row';
    public const AUTHOR_FIELD              = 'author_row';
    public const IMAGE_FIELD               = 'image_row';
    public const CATEGORIES_FIELD          = 'categories';

    /**
     * @param array<int, string> $categories
     * @param array<int,Translate> $translates
     * */
    private function __construct(
        public readonly string $id,
        public readonly string $changeActivity,
        public readonly array $translates,
        public readonly string $audioId,
        public readonly string $authorId,
        public readonly string $imageId,
        public readonly array $categories
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
                $language    = '';
                $rawLanguage = $rawTranslate[self::LANGUAGE_FIELD] ?? '';
                if (is_string($rawLanguage)) {
                    $language = $rawLanguage;
                }
                $name    = '';
                $rawName = $rawTranslate[self::NAME_FIELD] ?? '';
                if (is_string($rawName)) {
                    $name = $rawName;
                }
                $shortDescription    = '';
                $rawShortDescription = $rawTranslate[self::SHORT_DESCRIPTION_FIELD] ?? '';
                if (is_string($rawShortDescription)) {
                    $shortDescription = $rawShortDescription;
                }
                $description    = '';
                $rawDescription = $rawTranslate[self::DESCRIPTION_FIELD] ?? '';
                if (is_string($rawDescription)) {
                    $description = $rawDescription;
                }
                $translates[] = new Translate($language, $shortDescription, $description, $name);
            }
            $rawTranslates = $translates;
        }

        $imageId    = '';
        $rawImageId = $hash[self::IMAGE_FIELD] ?? '';
        if (is_string($rawImageId)) {
            $imageId = $rawImageId;
        }

        $authorId    = '';
        $rawAuthorId = $hash[self::AUTHOR_FIELD] ?? '';
        if (is_string($rawAuthorId)) {
            $authorId = $rawAuthorId;
        }

        $audioId    = '';
        $rawAudioId = $hash[self::AUDIO_FIELD] ?? '';
        if (is_string($rawAudioId)) {
            $audioId = $rawAudioId;
        }

        $categories    = [];
        $rawCategories = $hash[self::CATEGORIES_FIELD] ?? null;
        if (is_array($rawCategories)) {
            foreach ($rawCategories as $rawCategory) {
                $category = '';
                if (is_string($rawCategory)) {
                    $category = $rawCategory;
                }
                $categories[] = $category;
            }
        }

        return new self(
            $id,
            $changeActivity,
            $rawTranslates,
            $audioId,
            $authorId,
            $imageId,
            $categories
        );
    }
}
