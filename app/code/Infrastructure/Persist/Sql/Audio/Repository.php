<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\Audio;

use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\DatabaseTransactionException;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Site2\Application\Audio\AudioService\NoSuchAudioException;
use Romchik38\Site2\Application\Audio\AudioService\RepositoryException;
use Romchik38\Site2\Application\Audio\AudioService\RepositoryInterface;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Audio\Audio;
use Romchik38\Site2\Domain\Audio\Entities\Article;
use Romchik38\Site2\Domain\Audio\Entities\Translate;
use Romchik38\Site2\Domain\Audio\VO\Description;
use Romchik38\Site2\Domain\Audio\VO\Id;
use Romchik38\Site2\Domain\Audio\VO\Name;
use Romchik38\Site2\Domain\Audio\VO\Path;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

use function count;
use function json_decode;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function getById(Id $id): Audio
    {
        $query  = $this->getByIdQuery();
        $params = [$id()];
        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $count = count($rows);
        if ($count === 0) {
            throw new NoSuchAudioException(sprintf(
                'Audio with id %s not exist',
                $id()
            ));
        }
        if ($count > 1) {
            throw new RepositoryException(sprintf(
                'Audio with id %s has duplicates',
                $id()
            ));
        }

        $row = $rows[0];

        return $this->createModel($id, $row);
    }

    public function delete(Audio $model): void
    {
        $id = $model->getId();
        if ($id === null) {
            throw new RepositoryException('Could not delete audio from repository, id is not set');
        }
        $query  = $this->deleteQuery();
        $params = [$id()];
        try {
            $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }
    }

    public function save(Audio $model): void
    {
        $audioName = $model->getName();
        $audioId   = $model->getId();
        if ($audioId === null) {
            throw new RepositoryException('Audio id is not set');
        }
        if ($model->isActive()) {
            $audioActive = 't';
        } else {
            $audioActive = 'f';
        }

        $mainSaveQuery = $this->mainSaveQuery();
        $params        = [$audioActive, $audioName(), $audioId()];

        $translates = $model->getTranslates();

        try {
            $this->database->transactionStart();
            $this->database->transactionQueryParams(
                $mainSaveQuery,
                $params
            );

            $this->database->transactionQueryParams(
                $this->translatesSaveQueryDelete(),
                [$audioId()]
            );

            if (count($translates) > 0) {
                foreach ($translates as $translate) {
                    $this->database->transactionQueryParams(
                        $this->translatesSaveQueryInsert(),
                        [
                            (string) $translate->getDescription(),
                            (string) $translate->getPath(),
                            $audioId(),
                            (string) $translate->getLanguage(),
                        ]
                    );
                }
            }
            $this->database->transactionEnd();
        } catch (DatabaseTransactionException $e) {
            try {
                $this->database->transactionRollback();
                throw new RepositoryException(sprintf(
                    'Transaction error: %s, transaction rollback success',
                    $e->getMessage()
                ));
            } catch (DatabaseTransactionException $e2) {
                throw new RepositoryException(sprintf(
                    'Transaction error: %s, tried to rollback with error: %s',
                    $e->getMessage(),
                    $e2->getMessage()
                ));
            }
        } catch (QueryException $e) {
            try {
                $this->database->transactionRollback();
                throw new RepositoryException(sprintf(
                    'Query error: %s, transaction rollback success',
                    $e->getMessage()
                ));
            } catch (DatabaseTransactionException $e2) {
                throw new RepositoryException(sprintf(
                    'Query error: %s, tried to rollback with error: %s',
                    $e->getMessage(),
                    $e2->getMessage()
                ));
            }
        } catch (RepositoryException $e) {
            try {
                $this->database->transactionRollback();
                throw new RepositoryException($e->getMessage());
            } catch (DatabaseTransactionException $e2) {
                throw new RepositoryException(sprintf(
                    'Repository error: %s, tried to rollback with error: %s',
                    $e->getMessage(),
                    $e2->getMessage()
                ));
            }
        }
    }

    public function add(Audio $model): Audio
    {
        $modelId   = $model->getId();
        $audioName = $model->getName();

        if ($model->isActive()) {
            $audioActive = 't';
        } else {
            $audioActive = 'f';
        }

        if ($modelId === null) {
            $mainAddQuery = $this->mainAddQuery();
            $params       = [$audioActive, $audioName()];
        } else {
            $mainAddQuery = $this->mainAddQueryWithId();
            $params       = [$modelId(), $audioActive, $audioName()];
        }

        $translates = $model->getTranslates();

        try {
            $this->database->transactionStart();
            $rows = $this->database->transactionQueryParams(
                $mainAddQuery,
                $params
            );
            if (count($rows) !== 1) {
                throw new RepositoryException('Result must return 1 row with id while adding new audio');
            }
            $row        = $rows[0];
            $rawAudioId = $row['identifier'] ?? null;
            if ($rawAudioId === null) {
                throw new RepositoryException('Param id is invalid while adding new audio');
            }
            $audioId = Id::fromString($rawAudioId);
            foreach ($translates as $translate) {
                $this->database->transactionQueryParams(
                    $this->translatesAddQuery(),
                    [
                        $audioId(),
                        (string) $translate->getLanguage(),
                        (string) $translate->getDescription(),
                        (string) $translate->getPath(),
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
        } catch (RepositoryException $e) {
            try {
                $this->database->transactionRollback();
                throw new RepositoryException($e->getMessage());
            } catch (DatabaseTransactionException $e2) {
                throw new RepositoryException($e2->getMessage());
            }
        } catch (InvalidArgumentException $e) {
            try {
                $this->database->transactionRollback();
                throw new RepositoryException($e->getMessage());
            } catch (DatabaseTransactionException $e2) {
                throw new RepositoryException($e2->getMessage());
            }
        }

        return $this->getById($audioId);
    }

    /**
     * @throws RepositoryException
     * */
    public function addTranslate(Id $id, Translate $translate): void
    {
        $query  = $this->translatesAddQuery();
        $params = [
            $id(),
            (string) $translate->language,
            (string) $translate->description,
            (string) $translate->path,
        ];

        try {
            $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }
    }

    /**
     * @param array<string,string> $row
     * @throws InvalidArgumentException
     * @throws RepositoryException
     * */
    private function createModel(Id $id, array $row): Audio
    {
        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Audio active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        $rawName = $row['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Audio name is invalid');
        }

        $rawLanguages = $row['languages'] ?? null;
        if ($rawLanguages === null) {
            throw new RepositoryException('Audio languages param is invalid');
        }
        $languages = $this->createLanguages($rawLanguages);

        $articles = $this->createArticles($id);

        // ->
        $translates = $this->createTranslates($id);

        return Audio::load(
            $id,
            $active,
            new Name($rawName),
            $articles,
            $languages,
            $translates
        );
    }

    /**
     * @throws RepositoryException
     * @return array<int,Translate>
     * */
    private function createTranslates(Id $id): array
    {
        $query  = $this->translatesQuery();
        $params = [$id()];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $translates = [];
        foreach ($rows as $row) {
            $rawDescription = $row['description'] ?? null;
            if ($rawDescription === null) {
                throw new RepositoryException('Audio translate description is invalid');
            }
            $rawLanguage = $row['language'] ?? null;
            if ($rawLanguage === null) {
                throw new RepositoryException('Audio translate language is invalid');
            }
            $rawPath = $row['path'] ?? null;
            if ($rawPath === null) {
                throw new RepositoryException('Audio translate path is invalid');
            }
            $translates[] = new Translate(
                new LanguageId($rawLanguage),
                new Description($rawDescription),
                new Path($rawPath)
            );
        }
        return $translates;
    }

    /**
     * @throws RepositoryException
     * @return array<int,Article>
     */
    private function createArticles(Id $id): array
    {
        $query  = $this->articlesQuery();
        $params = [$id()];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $articles = [];
        foreach ($rows as $row) {
            $rawIdentifier = $row['identifier'] ?? null;
            if ($rawIdentifier === null) {
                throw new RepositoryException('Audio article identifier is invalid');
            }
            $rawActive = $row['active'] ?? null;
            if ($rawActive === null) {
                throw new RepositoryException('Audio article active is invalid');
            }
            if ($rawActive === 't') {
                $active = true;
            } else {
                $active = false;
            }
            $articles[] = new Article(
                new ArticleId($rawIdentifier),
                $active
            );
        }
        return $articles;
    }

    /**
     * @param string $rawLanguages - Json encoded array of strings
     * @return array<int,LanguageId>
     */
    private function createLanguages(string $rawLanguages): array
    {
        $decodedLanguages = json_decode($rawLanguages);

        $data = [];
        foreach ($decodedLanguages as $language) {
            $data[] = new LanguageId($language);
        }
        return $data;
    }

    private function getByIdQuery(): string
    {
        return <<<'QUERY'
            SELECT audio.active,
                audio.name,
                array_to_json (
                    array (SELECT language.identifier 
                        FROM language
                    ) 
                ) as languages
            FROM audio
            WHERE audio.identifier = $1
        QUERY;
    }

    private function articlesQuery(): string
    {
        return <<<'QUERY'
            SELECT article.identifier,
                article.active
            FROM article
            WHERE article.audio_id = $1
        QUERY;
    }

    private function translatesQuery(): string
    {
        return <<<'QUERY'
            SELECT audio_translates.language,
                audio_translates.description,
                audio_translates.path
            FROM audio_translates
            WHERE audio_translates.audio_id = $1
        QUERY;
    }

    private function mainSaveQuery(): string
    {
        return <<<'QUERY'
            UPDATE audio
            SET active = $1,
                name = $2
            WHERE audio.identifier = $3
        QUERY;
    }

    private function translatesSaveQueryDelete(): string
    {
        return <<<'QUERY'
        DELETE FROM audio_translates 
        WHERE audio_translates.audio_id = $1
        QUERY;
    }

    private function translatesAddQuery(): string
    {
        return <<<'QUERY'
        INSERT INTO audio_translates (audio_id, language, description, path)
            VALUES ($1, $2, $3, $4)
        QUERY;
    }

    private function mainAddQuery(): string
    {
        return <<<'QUERY'
            INSERT INTO audio (active, name)
                VALUES ($1, $2)
                RETURNING identifier
        QUERY;
    }

    private function mainAddQueryWithId(): string
    {
        return <<<'QUERY'
            INSERT INTO audio (identifier, active, name)
                VALUES ($1, $2, $3)
                RETURNING identifier
        QUERY;
    }

    private function deleteQuery(): string
    {
        return <<<'QUERY'
            DELETE FROM audio WHERE identifier = $1
        QUERY;
    }

    private function translatesSaveQueryInsert(): string
    {
        return <<<'QUERY'
        INSERT INTO audio_translates (description, path, audio_id, language)
        VALUES ($1, $2, $3, $4)
        QUERY;
    }
}
