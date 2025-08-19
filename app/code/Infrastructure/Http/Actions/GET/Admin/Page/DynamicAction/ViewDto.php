<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Page\DynamicAction;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Site2\Application\Language\List\View\LanguageDto;
use Romchik38\Site2\Application\Page\AdminView\View\PageDto;

final class ViewDto extends DefaultViewDTO
{
    /**
     * @param array<int,LanguageDto> $languages
     */
    public function __construct(
        string $name,
        string $description,
        public readonly PageDto $pageDto,
        public readonly string $idFiled,
        public readonly string $urlFiled,
        public readonly string $translateField,
        public readonly string $languageField,
        public readonly string $nameField,
        public readonly string $descriptionField,
        public readonly string $shortDescriptionField,
        public readonly array $languages,
        public readonly string $changeActivityField,
        public readonly string $yesField,
        public readonly string $noField
    ) {
        parent::__construct($name, $description);
    }
}
