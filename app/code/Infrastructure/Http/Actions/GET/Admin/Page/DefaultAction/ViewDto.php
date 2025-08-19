<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Page\DefaultAction;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Site2\Application\Page\AdminList\View\PageDto;

final class ViewDto extends DefaultViewDTO
{
    /** @param array<int,PageDto> $pageList */
    public function __construct(
        string $name,
        string $description,
        public readonly array $pageList,
        public readonly string $paginationHtml,
        public readonly PaginationForm $paginationForm,
        public readonly string $idFiled
    ) {
        parent::__construct($name, $description);
    }
}
