<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Root\DefaultAction;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Site2\Application\Banner\List\View\BannerDto;

final class ViewDTO extends DefaultViewDTO
{
    public function __construct(
        string $name,
        string $description,
        public readonly ?BannerDto $banner
    ) {
        parent::__construct($name, $description);
    }
}
