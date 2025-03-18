<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\ImageCache;

use Romchik38\Server\Models\Errors\CouldNotAddException;

interface ImageCacheRepositoryInterface
{
    /** @throws CouldNotAddException */
    public function add(ImageCache $model): void;

    /** Returns count of images in a storage*/
    public function totalCount(): int;

    /** total storage size in bytes */
    public function totalSize(): int;

    /** total storage size in kB, MB, GB, or TB */
    public function totalPrettySize(): string;

    /** Delete all data */
    public function deleteAll(): void;
}
