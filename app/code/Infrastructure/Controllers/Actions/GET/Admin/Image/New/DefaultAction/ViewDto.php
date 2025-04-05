<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Image\New\DefaultAction;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;
use Romchik38\Site2\Application\Language\ListView\View\LanguageDto;
use Romchik38\Site2\Application\Image\AdminView\View\AuthorDto;

final class ViewDto extends DefaultViewDTO
{
    /**
     * @param array<int,AuthorDto> $authors
     * @param array<int,LanguageDto> $languages
     */
    public function __construct(
        /** @todo usage */
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
        public readonly array $authors
    ) {
        parent::__construct($name, $description);
    }
}
