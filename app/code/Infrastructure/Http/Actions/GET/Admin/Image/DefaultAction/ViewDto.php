<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image\DefaultAction;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Site2\Application\Image\AdminImageListService\View\ImageDto;

final class ViewDto extends DefaultViewDTO
{
    /** @param array<int,ImageDto> $imagesList */
    public function __construct(
        string $name,
        string $description,
        public readonly array $imagesList,
        public readonly string $paginationHtml,
        public readonly PaginationForm $paginationForm,
        public readonly string $imageIdField,
    ) {
        parent::__construct($name, $description);
    }
}
