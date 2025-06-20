<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Banner\DynamicAction;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Site2\Application\Banner\AdminView\View\BannerDto;

final class ViewDto extends DefaultViewDTO
{
    public function __construct(
        string $name,
        string $description,
        public readonly BannerDto $bannerDto,
        public readonly string $csrfTokenField,
        public string $csrfToken,
        public readonly string $idField,
        public readonly string $nameField,
        public readonly string $priorityField,
        public readonly string $changeActivityField,
        public readonly string $yesField,
        public readonly string $noField,
        public readonly int $priorityMin,
        public readonly int $priorityMax,
    ) {
        parent::__construct($name, $description);
    }
}
