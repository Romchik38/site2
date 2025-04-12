<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Audio\DynamicAction;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;
use Romchik38\Site2\Application\Audio\AdminView\View\AudioDto;
use Romchik38\Site2\Application\Language\ListView\View\LanguageDto;

final class ViewDto extends DefaultViewDTO
{
    /**
     * @param array<int,LanguageDto> $languages
     */
    public function __construct(
        string $name,
        string $description,
        public readonly AudioDto $audioDto,
        public readonly string $csrfTokenField,
        public string $csrfToken,
        public readonly string $idFiled,
        public readonly string $nameFiled,
        public readonly string $changeActivityFiled,
        public readonly string $yesField,
        public readonly string $noField,
        public readonly array $languages
    ) {
        parent::__construct($name, $description);
    }
}
