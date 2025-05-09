<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Translate\DynamicAction;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Site2\Application\Language\List\View\LanguageDto;
use Romchik38\Site2\Application\Translate\View\View\TranslateDto;

final class ViewDto extends DefaultViewDTO
{
    /**
     * @param array<int,LanguageDto> $languages
     */
    public function __construct(
        string $name,
        string $description,
        public readonly TranslateDto $translateDto,
        public readonly string $csrfTokenField,
        public string $csrfToken,
        public readonly string $idFiled,
        public readonly string $translateField,
        public readonly string $languageField,
        public readonly string $phraseField,
        public readonly array $languages
    ) {
        parent::__construct($name, $description);
    }
}
