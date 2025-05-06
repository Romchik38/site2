<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author\DefaultAction;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Site2\Application\Author\AdminList\View\AuthorDto;

final class ViewDto extends DefaultViewDTO
{
    /** @param array<int,AuthorDto> $authorList */
    public function __construct(
        string $name,
        string $description,
        public readonly array $authorList,
        public readonly string $paginationHtml,
        public readonly PaginationForm $paginationForm,
        public readonly string $idFiled,
        public readonly string $csrfTokenField,
        public readonly string $csrfToken,
    ) {
        parent::__construct($name, $description);
    }
}
