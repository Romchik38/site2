<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ImageCache;

use Romchik38\Server\Models\Errors\QueryException;
use Romchik38\Server\Models\Sql\DatabaseSqlInterface;
use Romchik38\Site2\Application\ImageCache\ImageCacheService\Exceptions\RepositoryException;
use Romchik38\Site2\Application\ImageCache\ImageCacheService\RepositoryInterface;
use Romchik38\Site2\Domain\ImageCache\ImageCache;

final class Repository implements RepositoryInterface
{
    public function __construct(
        protected readonly DatabaseSqlInterface $database
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

        try {
            $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }
    }

    public function totalCount(): int
    {
        $query = 'SELECT count(key) FROM img_cache';

        try {
            $rows = $this->database->queryParams($query, []);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $result = $rows[0]['count'];

        return (int) $result;
    }

    public function totalSize(): int
    {
        $query = 'SELECT pg_total_relation_size (\'img_cache\')';
        try {
            $rows = $this->database->queryParams($query, []);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }
        $result = $rows[0]['pg_total_relation_size'];

        return (int) $result;
    }

    public function totalPrettySize(): string
    {
        $query = 'SELECT pg_size_pretty (pg_total_relation_size(\'img_cache\'))';
        try {
            $rows = $this->database->queryParams($query, []);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }
        return $rows[0]['pg_size_pretty'];
    }

    public function deleteAll(): void
    {
        $query = 'DELETE FROM img_cache';
        try {
            $this->database->queryParams($query, []);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }
    }
}
