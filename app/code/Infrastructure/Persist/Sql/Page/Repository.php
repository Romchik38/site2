<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\Page;

use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\DatabaseTransactionException;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Site2\Application\Page\PageService\Exceptions\NoSuchPageException;
use Romchik38\Site2\Application\Page\PageService\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Page\PageService\RepositoryInterface;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use Romchik38\Site2\Domain\Page\Entities\Translate;
use Romchik38\Site2\Domain\Page\Page;
use Romchik38\Site2\Domain\Page\VO\Description;
use Romchik38\Site2\Domain\Page\VO\Id as PageId;
use Romchik38\Site2\Domain\Page\VO\Name;
use Romchik38\Site2\Domain\Page\VO\ShortDescription;
use Romchik38\Site2\Domain\Page\VO\Url;

use function count;
use function json_decode;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function add(Page $model): PageId
    {
        $id = $model->id;
        if ($id !== null) {
            throw new RepositoryException(sprintf('Param page id %d can not be set for new model', $id()));
        }
        $active = 'f';
        $url    = (string) $model->url;

        $query  = $this->addQuery();
        $params = [$active, $url];
        try {
            $rows = $this->database->queryParams($query, $params);
            if (count($rows) !== 1) {
                throw new RepositoryException('Returns more than 1 id while creating new page');
            }
            $rawId = $rows[0]['id'] ?? null;
            if ($rawId === null) {
                throw new RepositoryException('Param page id is invalid');
            }
            try {
                return PageId::fromString($rawId);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }
    }

    public function delete(Page $model): void
    {
        $id = $model->id;
        if ($id === null) {
            throw new RepositoryException('Could not delete model, param page id is not set');
        }

        $query  = 'DELETE FROM page WHERE page.id = $1';
        $params = [$id()];
        try {
            $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }
    }

    public function getById(PageId $id): Page
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
            throw new NoSuchPageException(sprintf(
                'Page with id %s not exist',
                (string) $id
            ));
        }
        if ($count > 1) {
            throw new RepositoryException(sprintf(
                'Page with id %s has duplicates',
                (string) $id
            ));
        }

        return $this->createFromRow($rows[0], $id);
    }

    public function save(Page $model): void
    {
        $pageId = $model->id;
        if ($pageId === null) {
            throw new RepositoryException('Could not save model, param page id is not set');
        }
        $pageUrl = ($model->url)();
        if ($model->active) {
            $pageActive = 't';
        } else {
            $pageActive = 'f';
        }

        $mainSaveQuery = $this->mainSaveQuery();
        $params        = [$pageId(), $pageActive, $pageUrl];

        $translates = $model->getTranslates();

        try {
            $this->database->queryParams($mainSaveQuery, $params);
            $this->database->queryParams($this->translatesSaveQueryDelete(), [$pageId()]);
            if (count($translates) > 0) {
                foreach ($translates as $translate) {
                    $this->database->queryParams(
                        $this->translatesSaveQueryInsert(),
                        [
                            $pageId(),
                            (string) $translate->language,
                            (string) $translate->name,
                            (string) $translate->shortDescription,
                            (string) $translate->description,
                        ]
                    );
                }
            }
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }
    }

    public function transactionCancel(): void
    {
        try {
            $this->database->transactionRollback();
        } catch (DatabaseTransactionException $e) {
            throw new RepositoryException($e->getMessage());
        }
    }

    public function transactionEnd(): void
    {
        try {
            $this->database->transactionEnd();
        } catch (DatabaseTransactionException $e) {
            throw new RepositoryException($e->getMessage());
        }
    }

    public function transactionStart(): void
    {
        try {
            $this->database->transactionStart($this->database::ISOLATION_LEVEL_REPEATABLE_READ);
        } catch (DatabaseTransactionException $e) {
            throw new RepositoryException($e->getMessage());
        }
    }

    /**
     * @throws RepositoryException
     * @param array<string,string|null> $row
     * */
    private function createFromRow(array $row, PageId $id): Page
    {
        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Page active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        $rawUrl = $row['url'] ?? null;
        if ($rawUrl === null) {
            throw new RepositoryException('Page url is invalid');
        }

        $rawLanguages = $row['languages'] ?? null;
        if ($rawLanguages === null) {
            throw new RepositoryException('Page languages param is invalid');
        }

        try {
            $url        = new Url($rawUrl);
            $languages  = $this->createLanguages($rawLanguages);
            $translates = $this->createTranslates($id);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        return new Page($id, $active, $url, $languages, $translates);
    }

    /**
     * @throws RepositoryException
     * @return array<int,Translate>
     * */
    private function createTranslates(PageId $id): array
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
            $rawLanguage = $row['language'] ?? null;
            if ($rawLanguage === null) {
                throw new RepositoryException('Page translate language param is invalid');
            }
            $rawShortDescription = $row['short_description'] ?? null;
            if ($rawShortDescription === null) {
                throw new RepositoryException('Page translate short description param is invalid');
            }
            $rawDescription = $row['description'] ?? null;
            if ($rawDescription === null) {
                throw new RepositoryException('Page translate description param is invalid');
            }
            $rawName = $row['name'] ?? null;
            if ($rawName === null) {
                throw new RepositoryException('Page translate name param is invalid');
            }

            $translates[] = new Translate(
                new LanguageId($rawLanguage),
                new Name($rawName),
                new ShortDescription($rawShortDescription),
                new Description($rawDescription)
            );
        }

        return $translates;
    }

    /**
     * @param string $rawLanguages - Json encoded array of strings
     * @throws InvalidArgumentException
     * @return array<int,LanguageId>
     */
    private function createLanguages(string $rawLanguages): array
    {
        $decodedLanguages = json_decode($rawLanguages);
        $data             = [];
        foreach ($decodedLanguages as $language) {
            $data[] = new LanguageId($language);
        }
        return $data;
    }

    private function getByIdQuery(): string
    {
        return <<<'QUERY'
        SELECT page.active,
            page.url,
            array_to_json (array (SELECT language.identifier FROM language)) as languages
        FROM page
        WHERE page.id = $1
        QUERY;
    }

    private function translatesQuery(): string
    {
        return <<<'QUERY'
        SELECT page_translates.language,
            page_translates.name,
            page_translates.short_description,
            page_translates.description
        FROM page_translates
        WHERE page_translates.page_id = $1
        QUERY;
    }

    private function mainSaveQuery(): string
    {
        return <<<'QUERY'
            UPDATE page
            SET active = $2,
                url = $3
            WHERE page.id = $1
        QUERY;
    }

    private function translatesSaveQueryDelete(): string
    {
        return <<<'QUERY'
            DELETE FROM page_translates
            WHERE page_id = $1
        QUERY;
    }

    private function translatesSaveQueryInsert(): string
    {
        return <<<'QUERY'
            INSERT INTO page_translates (
                page_id,
                language,
                name,
                short_description,
                description
            ) VALUES ($1, $2, $3, $4, $5)
        QUERY;
    }

    private function addQuery(): string
    {
        return <<<'QUERY'
            INSERT INTO page (active, url)
                VALUES ($1, $2)
                RETURNING id
        QUERY;
    }
}
