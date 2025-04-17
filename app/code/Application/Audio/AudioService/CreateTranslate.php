<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AudioService;

use function is_string;

final class CreateTranslate
{
    public const AUDIO_ID_FIELD = 'audio_id';
    public const LANGUAGE_FIELD    = 'language';
    public const DESCRIPTION_FIELD = 'description';
    public const FILE_FIELD        = 'file';
    public const FOLDER_FIELD      = 'folder';
    public const ALLOWED_FOLDERS   = ['articles'];

    private function __construct(
        public readonly string $id,
        public readonly string $language,
        public readonly string $description,
        public readonly string $folder,
        public readonly mixed $file
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

        $description    = '';
        $rawDescription = $hash[self::DESCRIPTION_FIELD] ?? '';
        if (is_string($rawDescription)) {
            $description = $rawDescription;
        }

        $folder    = '';
        $rawFolder = $hash[self::FOLDER_FIELD] ?? '';
        if (is_string($rawFolder)) {
            $folder = $rawFolder;
        }

        return new self(
            $id, 
            $language, 
            $description, 
            $folder,
            $hash[self::FILE_FIELD] ?? null
        );
    }
}
