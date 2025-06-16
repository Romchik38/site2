<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Banner\DefaultAction;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Site2\Application\Banner\AdminList\View\BannerDto;

final class ViewDto extends DefaultViewDTO
{
    /** @param array<int,BannerDto> $banners */
    public function __construct(
        string $name,
        string $description,
        public readonly array $banners,
        public readonly string $csrfTokenField,
        public string $csrfToken,
        public readonly string $bannerIdField,
    ) {
        parent::__construct($name, $description);
    }
}
