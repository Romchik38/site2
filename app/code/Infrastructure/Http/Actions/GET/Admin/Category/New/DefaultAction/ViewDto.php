<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Category\New\DefaultAction;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Site2\Application\Language\List\View\LanguageDto;

final class ViewDto extends DefaultViewDTO
{
    /**
     * @param array<int,LanguageDto> $languages
     */
    public function __construct(
        string $name,
        string $description,
        public readonly string $idFiled,
        public readonly string $translateField,
        public readonly string $languageField,
        public readonly string $nameField,
        public readonly string $descriptionField,
        public readonly array $languages
    ) {
        parent::__construct($name, $description);
    }
}
