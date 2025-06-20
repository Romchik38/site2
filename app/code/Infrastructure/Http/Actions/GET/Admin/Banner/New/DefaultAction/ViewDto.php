<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Banner\New\DefaultAction;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;

final class ViewDto extends DefaultViewDTO
{
    public readonly ImageFiltersDto $imageFilters;

    public function __construct(
        string $name,
        string $description,
        public readonly string $csrfTokenField,
        public string $csrfToken,
        public readonly string $nameField,
        public readonly string $priorityField,
        public readonly string $imageField
    ) {
        parent::__construct($name, $description);
        $this->imageFilters = new ImageFiltersDto();
    }
}
