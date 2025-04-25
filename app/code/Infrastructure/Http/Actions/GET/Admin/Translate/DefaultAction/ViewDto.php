<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Translate\DefaultAction;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;
use Romchik38\Site2\Application\Translate\ListView\View\TranslateDto;

final class ViewDto extends DefaultViewDTO
{
    /** @param array<int,TranslateDto> $translateList */
    public function __construct(
        string $name,
        string $description,
        public readonly array $translateList,
        public readonly string $paginationHtml,
        public readonly PaginationForm $paginationForm,
        public readonly string $idFiled,
        public readonly string $csrfTokenField,
        public readonly string $csrfToken,
    ) {
        parent::__construct($name, $description);
    }
}
