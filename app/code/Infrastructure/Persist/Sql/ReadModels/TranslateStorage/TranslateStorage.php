<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\TranslateStorage;

use Romchik38\Server\Models\Errors\QueryException;
use Romchik38\Server\Models\Sql\DatabaseSqlInterface;
use Romchik38\Server\Services\Translate\NoSuchTranslateException;
use Romchik38\Server\Services\Translate\TranslateEntityDTO;
use Romchik38\Server\Services\Translate\TranslateEntityDTOInterface;
use Romchik38\Server\Services\Translate\TranslateStorageException;
use Romchik38\Server\Utils\Translate\TranslateStorageInterface;

use function count;
use function sprintf;

final class TranslateStorage implements TranslateStorageInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function getByKey(string $key): TranslateEntityDTOInterface
    {
        $query  = $this->defaultQuery();
        $params = [$key];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new TranslateStorageException($e->getMessage());
        }

        if (count($rows) === 0) {
            throw new NoSuchTranslateException(sprintf(
                'translate key %s not exist',
                $key
            ));
        }

        $data = [];
        foreach ($rows as $row) {
            $rawLanguage = $row['language'] ?? null;
            if ($rawLanguage === null) {
                throw new TranslateStorageException(
                    'Translate entity parameter language is invalid'
                );
            }
            $rawPhrase = $row['phrase'] ?? null;
            if ($rawPhrase === null) {
                throw new TranslateStorageException(
                    'Translate entity parameter phrase is invalid'
                );
            }
            $data[$rawLanguage] = $rawPhrase;
        }

        return new TranslateEntityDTO($key, $data);
    }

    private function defaultQuery(): string
    {
        return <<<'QUERY'
        SELECT translate_entities.language,
            translate_entities.phrase
        FROM translate_entities
        WHERE translate_entities.key = $1
        QUERY;
    }
}
