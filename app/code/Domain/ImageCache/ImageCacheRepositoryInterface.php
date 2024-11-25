<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\ImageCache;

use Romchik38\Server\Models\Errors\CouldNotAddException;

interface ImageCacheRepositoryInterface
{
    /** @throws CouldNotAddException */
    public function add(ImageCache $model): void;
}
