<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Category\DefaultAction;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Site2\Application\Banner\List\View\BannerDto;
use Romchik38\Site2\Application\Category\List\View\CategoryDto;

final class ViewDTO extends DefaultViewDTO
{
    /** @param array<int,CategoryDto> $categories */
    public function __construct(
        string $name,
        string $description,
        public readonly array $categories,
        public readonly ?BannerDto $banner,
    ) {
        parent::__construct($name, $description);
    }
}
