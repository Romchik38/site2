<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Author\DynamicAction;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;
use Romchik38\Site2\Application\Author\AdminView\View\AuthorDto;

final class ViewDto extends DefaultViewDTO
{
    public function __construct(
        string $name,
        string $description,
        public readonly AuthorDto $authorDto,
        public readonly string $csrfTokenField,
        public string $csrfToken
    ) {
        parent::__construct($name, $description);
    }
}
