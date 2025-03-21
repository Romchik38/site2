<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Language\View;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;
use Romchik38\Site2\Application\Language\ListView\View\LanguageDto;

final class ViewDto extends DefaultViewDTO
{
    /** @param array<int,LanguageDto> */
    public function __construct(
        string $name,
        string $description,
        public readonly array $languages
    ) {
        parent::__construct($name, $description);
    }
}