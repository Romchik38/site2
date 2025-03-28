<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\Translate;

use Romchik38\Server\Models\Errors\QueryException;
use Romchik38\Server\Models\Sql\DatabaseInterface;
use Romchik38\Server\Models\Sql\DatabaseTransactionException;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use Romchik38\Site2\Domain\Translate\RepositoryInterface;
use Romchik38\Site2\Domain\Translate\RepositoryException;
use Romchik38\Site2\Domain\Translate\NoSuchTranslateException;
use Romchik38\Site2\Domain\Translate\CouldNotSaveException;
use Romchik38\Site2\Domain\Translate\CouldDeleteException;
use Romchik38\Site2\Domain\Translate\Entities\Phrase;
use Romchik38\Site2\Domain\Translate\Translate;
use Romchik38\Site2\Domain\Translate\VO\Identifier;
use Romchik38\Site2\Domain\Translate\VO\Phrase as VOPhrase;

final class Repository implements RepositoryInterface
{
    public  function __construct(
        private  readonly DatabaseInterface $database
    ) {   
    }

    /**
     * @throws NoSuchTranslateException
     * @throws RepositoryException
     * */
    public function getById(Identifier $id): Translate
    {
        $query = $this->getByIdQuery();
        $params = [$id()];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch(QueryException $e) {
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

    /** @throws CouldDeleteException */
    public function deleteById(Identifier $id): void
    {
        $query = 'DELETE FROM translate_keys WHERE translate_keys.identifier = $1';
        $params = [$id()];
        try {
            $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }
    }

    /** @throws CouldNotSaveException */
    public function save(Translate $model): Translate
    {
        $id = $model->getId();
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
                throw new CouldNotSaveException($e->getMessage());
            } catch (DatabaseTransactionException $e2) {
                throw new CouldNotSaveException($e2->getMessage());
            }
        } catch (QueryException $e) {
            try {
                $this->database->transactionRollback();
                throw new CouldNotSaveException($e->getMessage());
            } catch (DatabaseTransactionException $e2) {
                throw new CouldNotSaveException($e2->getMessage());
            }
        }
        return $this->getById($id);
    }

    /** @throws CouldNotSaveException */
    public function add(Translate $model): Translate
    {
        $id = $model->getId();
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
                throw new CouldNotSaveException($e->getMessage());
            } catch (DatabaseTransactionException $e2) {
                throw new CouldNotSaveException($e2->getMessage());
            }
        } catch (QueryException $e) {
            try {
                $this->database->transactionRollback();
                throw new CouldNotSaveException($e->getMessage());
            } catch (DatabaseTransactionException $e2) {
                throw new CouldNotSaveException($e2->getMessage());
            }
        }
        return $this->getById($id);
    }

    /** @return array<int,Phrase> */
    private function createPhrases(Identifier $id): array
    {
        $query = $this->querySelectPhrases();
        $params = [$id()];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch(QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $phrases = [];

        foreach ($rows as $row) {
            $rawLanguage = $row['language'] ?? null;
            if ($rawLanguage === null) {
                throw new RepositoryException('Translate language is ivalid');
            }
            $rawPhrase = $row['phrase'] ?? null;
            if ($rawPhrase === null) {
                throw new RepositoryException('Translate phrase is ivalid');
            }
            $phrases[] = new Phrase(
                new LanguageId($rawLanguage),
                new VOPhrase($rawPhrase)
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