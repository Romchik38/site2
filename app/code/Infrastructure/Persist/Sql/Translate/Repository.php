<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\Translate;

use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\DatabaseTransactionException;
use Romchik38\Site2\Application\Translate\TranslateService\Exceptions\NoSuchTranslateException;
use Romchik38\Site2\Application\Translate\TranslateService\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Translate\TranslateService\RepositoryInterface;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use Romchik38\Site2\Domain\Translate\Entities\Phrase;
use Romchik38\Site2\Domain\Translate\Translate;
use Romchik38\Site2\Domain\Translate\VO\Identifier;
use Romchik38\Site2\Domain\Translate\VO\Phrase as VOPhrase;

use function count;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function getById(Identifier $id): Translate
    {
        $query  = $this->getByIdQuery();
        $params = [$id()];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        if (count($rows) === 0) {
            throw new NoSuchTranslateException(sprintf(
                'Translate with id %s not exist',
                $id()
            ));
        }

        $phrases = $this->createPhrases($id);

        return new Translate($id, $phrases);
    }

    public function deleteById(Identifier $id): void
    {
        $query  = 'DELETE FROM translate_keys WHERE translate_keys.identifier = $1';
        $params = [$id()];
        try {
            $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }
    }

    public function save(Translate $model): void
    {
        $id      = $model->getId();
        $phrases = $model->getPhrases();
        try {
            $this->database->transactionStart();
            $this->database->transactionQueryParams(
                $this->deletePhrasesQuery(),
                [$id()]
            );
            foreach ($phrases as $phrase) {
                $this->database->transactionQueryParams(
                    $this->phrasesSaveQueryInsert(),
                    [
                        $id(),
                        (string) $phrase->getLanguage(),
                        (string) $phrase->getPhrase(),
                    ]
                );
            }
            $this->database->transactionEnd();
        } catch (DatabaseTransactionException $e) {
            try {
                $this->database->transactionRollback();
                throw new RepositoryException($e->getMessage());
            } catch (DatabaseTransactionException $e2) {
                throw new RepositoryException($e2->getMessage());
            }
        } catch (QueryException $e) {
            try {
                $this->database->transactionRollback();
                throw new RepositoryException($e->getMessage());
            } catch (DatabaseTransactionException $e2) {
                throw new RepositoryException($e2->getMessage());
            }
        }
    }

    public function add(Translate $model): void
    {
        $id      = $model->getId();
        $phrases = $model->getPhrases();
        try {
            $this->database->transactionStart();
            $this->database->transactionQueryParams(
                $this->insertTranslateQuery(),
                [$id()]
            );
            foreach ($phrases as $phrase) {
                $this->database->transactionQueryParams(
                    $this->phrasesSaveQueryInsert(),
                    [
                        $id(),
                        (string) $phrase->getLanguage(),
                        (string) $phrase->getPhrase(),
                    ]
                );
            }
            $this->database->transactionEnd();
        } catch (DatabaseTransactionException $e) {
            try {
                $this->database->transactionRollback();
                throw new RepositoryException($e->getMessage());
            } catch (DatabaseTransactionException $e2) {
                throw new RepositoryException($e2->getMessage());
            }
        } catch (QueryException $e) {
            try {
                $this->database->transactionRollback();
                throw new RepositoryException($e->getMessage());
            } catch (DatabaseTransactionException $e2) {
                throw new RepositoryException($e2->getMessage());
            }
        }
    }

    /**
     * @throws RepositoryException
     * @return array<int,Phrase>
     * */
    private function createPhrases(Identifier $id): array
    {
        $query  = $this->querySelectPhrases();
        $params = [$id()];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $phrases = [];

        foreach ($rows as $row) {
            $rawLanguage = $row['language'] ?? null;
            if ($rawLanguage === null) {
                throw new RepositoryException('Translate language is invalid');
            }
            $rawPhrase = $row['phrase'] ?? null;
            if ($rawPhrase === null) {
                throw new RepositoryException('Translate phrase is invalid');
            }
            try {
                $language = new LanguageId($rawLanguage);
                $phrase   = new VOPhrase($rawPhrase);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }
            $phrases[] = new Phrase(
                $language,
                $phrase
            );
        }

        return $phrases;
    }

    private function deletePhrasesQuery(): string
    {
        return <<<'QUERY'
        DELETE FROM translate_entities
        WHERE translate_entities.key = $1
        QUERY;
    }

    private function getByIdQuery(): string
    {
        return <<<'QUERY'
        SELECT translate_keys.identifier
        FROM translate_keys
        WHERE translate_keys.identifier = $1
        QUERY;
    }

    private function phrasesSaveQueryInsert(): string
    {
        return <<<'QUERY'
        INSERT INTO translate_entities (key, language, phrase)
        VALUES ($1, $2, $3)
        QUERY;
    }

    private function insertTranslateQuery(): string
    {
        return <<<'QUERY'
        INSERT INTO translate_keys (identifier)
        VALUES ($1)
        QUERY;
    }

    private function querySelectPhrases(): string
    {
        return <<<'QUERY'
        SELECT translate_entities.language,
            translate_entities.phrase
        FROM translate_entities
        WHERE translate_entities.key = $1
        QUERY;
    }
}
