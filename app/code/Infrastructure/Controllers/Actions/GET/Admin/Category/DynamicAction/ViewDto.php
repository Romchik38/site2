<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Category\DynamicAction;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;
use Romchik38\Site2\Application\Category\AdminView\View\CategoryDto;
use Romchik38\Site2\Application\Language\ListView\View\LanguageDto;

final class ViewDto extends DefaultViewDTO
{
    /**
     * @param array<int,LanguageDto> $languages
     */
    public function __construct(
        string $name,
        string $description,
        public readonly CategoryDto $categoryDto,
        public readonly string $csrfTokenField,
        public string $csrfToken,
        public readonly string $idFiled,
        public readonly string $translateField,
        public readonly string $languageField,
        public readonly string $nameField,
        public readonly string $descriptionField,
        public readonly array $languages,
        public readonly string $changeActivityField,
        public readonly string $yesField,
        public readonly string $noField
    ) {
        parent::__construct($name, $description);
    }
}
