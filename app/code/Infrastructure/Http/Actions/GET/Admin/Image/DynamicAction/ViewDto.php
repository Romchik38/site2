<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image\DynamicAction;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;
use Romchik38\Site2\Application\Image\AdminView\View\Dto as ImageDto;
use Romchik38\Site2\Application\Image\AdminView\View\MetadataDto;
use Romchik38\Site2\Application\Language\ListView\View\LanguageDto;

final class ViewDto extends DefaultViewDTO
{
    /**
     * @param array<int,LanguageDto> $languages
     */
    public function __construct(
        string $name,
        string $description,
        public readonly ImageDto $imageDto,
        public readonly MetadataDto $metadataDto,
        public readonly string $imageFrontendPath,
        public readonly array $languages,
        public readonly string $csrfTokenField,
        public string $csrfToken,
        public readonly string $idFiled,
        public readonly string $nameFiled,
        public readonly string $authorIdFiled,
        public readonly string $changeAuthorIdFiled,
        public readonly string $changeAuthorField,
        public readonly string $changeActivityField,
        public readonly string $yesField,
        public readonly string $noField,
        public readonly string $translateField,
        public readonly string $languageField,
        public readonly string $descriptionField,
    ) {
        parent::__construct($name, $description);
    }
}
