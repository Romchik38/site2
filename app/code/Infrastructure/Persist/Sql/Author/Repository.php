<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\Author;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Site2\Domain\Author\Author;
use Romchik38\Site2\Domain\Author\NoSuchAuthorException;
use Romchik38\Site2\Domain\Author\RepositoryInterface;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Name;
use Romchik38\Site2\Domain\Author\RepositoryException;
use Romchik38\Site2\Domain\Author\DuplicateIdException;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use Romchik38\Site2\Domain\Author\Entities\Translate;
use Romchik38\Site2\Domain\Author\VO\Description;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseInterface $database
    ) {   
    }

    public function getById(AuthorId $id): Author
    {
        $params = [$id()];
        $query = $this->defaultQuery();

        $rows = $this->database->queryParams($query, $params);
        
        $rowsCount = count($rows);
        if ($rowsCount === 0) {
            throw new NoSuchAuthorException(sprintf(
                'Author with is %s not exist',
                $id()
            ));
        }
        if ($rowsCount > 1) {
            throw new DuplicateIdException(sprintf(
                'Author with is %s has duplicates',
                $id()
            ));
        }

        $model = $this->createFromRow($rows[0]);
        return $model;
    }
    
    /** @todo implement */
    public function save(Author $model): Author
    {
        return $model;
    }

    /** @param array<string,string> $row */
    protected function createFromRow(array $row): Author
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Author id is ivalid');
        }

        $rawName = $row['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Author name is ivalid');
        }

        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Author active is ivalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        $rawLanguages = $row['languages'] ?? null;
        if ($rawLanguages === null) {
            throw new RepositoryException('Author languages param is ivalid');
        }
        
        $languages = $this->prepareRawLanguages($rawLanguages);

        // translates
        $translates = $this->createTranslates($rawIdentifier);

        // create a model
        return Author::load(
            new AuthorId($rawIdentifier),
            new Name($rawName),
            $active,
            [],
            [],
            $languages,
            $translates
        );
    }

    /** @return array<int,Translate> */
    protected function createTranslates(string $authorId): array
    {
        $translates = [];

        $params = [$authorId];
        $query = $this->translatesQuery();

        $rows = $this->database->queryParams($query, $params);

        foreach ($rows as $row) {
            $rawLanguage = $row['language'] ?? null;
            if ($rawLanguage === null) {
                throw new RepositoryException('Author translates language param is ivalid');
            }
            $rawDescription = $row['description'] ?? null;
            if ($rawLanguage === null) {
                throw new RepositoryException('Author translates description param is ivalid');
            }
            $translates[] = new Translate(
                new LanguageId($rawLanguage),
                new Description($rawDescription)
            );
        }

        return $translates;
    }

    /**
     * @param string $languages - Json encoded array of string
     * @return array<int,LanguageId>
     */
    protected function prepareRawLanguages(string $rawLanguages): array
    {
        $decodedLanguages = json_decode($rawLanguages);

        $data = [];
        foreach ($decodedLanguages as $language) {
            $data[] = new LanguageId($language);
        }
        return $data;
    }

    
    protected function defaultQuery(): string
    {
        return <<<'QUERY'
        SELECT author.identifier,
            author.name,
            author.active,
            array_to_json (
                array (SELECT language.identifier 
                    FROM language
                ) 
            ) as languages
        FROM author
        WHERE author.identifier = $1
        QUERY;
    }

    protected function translatesQuery(): string
    {
        return <<<'QUERY'
        SELECT author_translates.language,
            author_translates.description
        FROM author_translates
        WHERE author_translates.author_id = $1
        QUERY;
    }
}