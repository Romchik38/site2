<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\New\DefaultAction;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;

final class ViewDto extends DefaultViewDTO
{
    public function __construct(
        string $name,
        string $description,
        public readonly string $csrfTokenField,
        public string $csrfToken,
        public readonly string $idFiled,
        public readonly string $authorField,
        public readonly AuthorFiltersDto $authorFilters
    ) {
        parent::__construct($name, $description);
    }
}
