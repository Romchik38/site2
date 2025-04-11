<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Audio\DefaultAction;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;
use Romchik38\Site2\Application\Audio\AdminList\View\AudioDto;

final class ViewDto extends DefaultViewDTO
{
    /** @param array<int,AudioDto> $audioList */
    public function __construct(
        string $name,
        string $description,
        public readonly array $audioList,
        public readonly string $paginationHtml,
        public readonly PaginationForm $paginationForm,
        public readonly string $idFiled,
        public readonly string $csrfTokenField,
        public readonly string $csrfToken,
    ) {
        parent::__construct($name, $description);
    }
}
