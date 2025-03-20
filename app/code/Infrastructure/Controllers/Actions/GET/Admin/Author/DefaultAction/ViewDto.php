<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Author\DefaultAction;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;
use Romchik38\Site2\Application\Author\AdminAuthorList\View\AuthorDto;

final class ViewDto extends DefaultViewDTO
{
    /** @param array<int,AuthorDto> $authorList */
    public function __construct(
        string $name,
        string $description,
        public readonly array $authorList,
        public readonly string $paginationHtml,
        public readonly PaginationForm $paginationForm
    ) {
        parent::__construct($name, $description);
    }
}
