<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Root\DefaultAction;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Site2\Application\Banner\List\View\BannerDto;

final class ViewDTO extends DefaultViewDTO
{
    /** @param array<int,BannerDto> $banners */
    public function __construct(
        string $name,
        string $description,
        public readonly array $banners
    ) {
        parent::__construct($name, $description);
    }
}
