<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image\New\DefaultAction;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;
use Romchik38\Site2\Application\Image\AdminView\View\AuthorDto;
use Romchik38\Site2\Application\Image\AdminView\View\ImageRequirementsDto;
use Romchik38\Site2\Application\Language\ListView\View\LanguageDto;

final class ViewDto extends DefaultViewDTO
{
    /**
     * @param array<int,AuthorDto> $authors
     * @param array<int,string> $folders
     * @param array<int,LanguageDto> $languages
     */
    public function __construct(
        string $name,
        string $description,
        public readonly array $languages,
        public readonly string $csrfTokenField,
        public string $csrfToken,
        public readonly string $nameFiled,
        public readonly string $authorIdFiled,
        public readonly string $translateField,
        public readonly string $languageField,
        public readonly string $descriptionField,
        public readonly array $authors,
        public readonly ImageRequirementsDto $imageRequirements,
        public readonly string $fileField,
        public readonly string $folderField,
        public readonly array $folders
    ) {
        parent::__construct($name, $description);
    }
}
