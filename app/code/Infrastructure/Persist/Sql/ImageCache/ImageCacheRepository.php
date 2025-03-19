<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ImageCache;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Site2\Domain\ImageCache\ImageCache;
use Romchik38\Site2\Domain\ImageCache\ImageCacheRepositoryInterface;

final class ImageCacheRepository implements ImageCacheRepositoryInterface
{
    public function __construct(
        protected readonly DatabaseInterface $database
    ) {
    }

    public function add(ImageCache $model): void
    {
        $query  = 'INSERT INTO img_cache (key, data, type, created_at) VALUES ($1, $2, $3, $4)';
        $params = [
            ($model->key())(),
            ($model->data())(),
            ($model->type())(),
            ($model->createdAt())->toString(),
        ];

        $this->database->queryParams($query, $params);
    }

    public function totalCount(): int
    {
        $query = 'SELECT count(key) FROM img_cache';

        $rows   = $this->database->queryParams($query, []);
        $result = $rows[0]['count'];

        return (int) $result;
    }

    public function totalSize(): int
    {
        $query = 'SELECT pg_total_relation_size (\'img_cache\')';

        $rows   = $this->database->queryParams($query, []);
        $result = $rows[0]['pg_total_relation_size'];

        return (int) $result;
    }

    public function totalPrettySize(): string
    {
        $query = 'SELECT pg_size_pretty (pg_total_relation_size(\'img_cache\'))';

        $rows = $this->database->queryParams($query, []);
        return $rows[0]['pg_size_pretty'];
    }

    public function deleteAll(): void
    {
        $query = 'DELETE FROM img_cache';

        $this->database->queryParams($query, []);
    }
}
