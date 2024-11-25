<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ImageCache;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Site2\Domain\ImageCache\ImageCache as ImageCacheImageCache;
use Romchik38\Site2\Domain\ImageCache\ImageCacheRepositoryInterface;

final class ImageCacheRepository implements ImageCacheRepositoryInterface
{
    public function __construct(
        protected readonly DatabaseInterface $database
    ) {}

    public function add(ImageCacheImageCache $model): void
    {
        $query = 'INSERT INTO img_cache (key, data, type, created_at) VALUES ($1, $2, $3, $4)';
        $params = [
            ($model->key())(),
            ($model->data())(),
            ($model->type())(),
            ($model->createdAt())->toString(),
        ];

        $this->database->queryParams($query, $params);
    }
}
