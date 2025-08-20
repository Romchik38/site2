<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Imagecache\DefaultAction;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;

final class ViewDto extends DefaultViewDTO
{
    public function __construct(
        string $name,
        string $description,
        public int $totalCount,
        public string $totalPrettySize,
        public int $totalSize,
        public int $maxCacheSize
    ) {
        parent::__construct($name, $description);
    }
}
