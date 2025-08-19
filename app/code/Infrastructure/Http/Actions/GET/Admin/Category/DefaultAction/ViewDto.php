<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Category\DefaultAction;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Site2\Application\Category\AdminList\View\CategoryDto;

final class ViewDto extends DefaultViewDTO
{
    /** @param array<int,CategoryDto> $categoryList */
    public function __construct(
        string $name,
        string $description,
        public readonly array $categoryList,
        public readonly string $paginationHtml,
        public readonly PaginationForm $paginationForm,
        public readonly string $idFiled
    ) {
        parent::__construct($name, $description);
    }
}
