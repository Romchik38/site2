<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Author\AdminView;

use Romchik38\Server\Models\Sql\DatabaseInterface;
use Romchik38\Server\Models\Errors\QueryException;
use Romchik38\Site2\Application\Author\AdminView\RepositoryInterface;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Application\Author\AdminView\View\AuthorDto;
use Romchik38\Site2\Application\Author\AdminView\RepositoryException;
use Romchik38\Site2\Domain\Author\NoSuchAuthorException;
use Romchik38\Site2\Domain\Author\DuplicateIdException;
use Romchik38\Site2\Domain\Author\Entities\Translate;
use Romchik38\Site2\Domain\Author\VO\Description;
use Romchik38\Site2\Domain\Language\VO\Identifier;
use Romchik38\Site2\Domain\Article\VO\ArticleId;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;

use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseInterface $database
    ) {   
    }
    
    public function getById(AuthorId $id): AuthorDto
    {
        $idAsString = $id();
        $params = [$idAsString];

        $query = $this->defaultQuery();

        $rows = $this->database->queryParams($query, $params);
        $rowCount = count($rows);
        if ($rowCount === 0) {
            throw new NoSuchAuthorException(sprintf(
                'Author with id %s not exist',
                $idAsString
            ));
        }
        if ($rowCount > 1) {
            throw new DuplicateIdException(sprintf(
                'Author with id %s has duplicates',
                $idAsString
            ));
        }

        $firstRow = $rows[0];
        return $this->createFromRow($firstRow);
    }

    /** @param array<string,string> $row */
    protected function createFromRow(array $row): AuthorDto
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Author id is ivalid');
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

        $rawName = $row['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Author name is ivalid');
        }

        $translates = $this->createTranslates($rawIdentifier);
        
        $rawArticles = $row['articles'] ?? null;
        if ($rawArticles === null) {
            throw new RepositoryException('Author articles is ivalid');
        }
        $articles = $this->prepareRawArticles($rawArticles);

        $rawImages = $row['images'] ?? null;
        if ($rawImages === null) {
            throw new RepositoryException('Author images is ivalid');
        }
        $images = $this->prepareRawImages($rawImages);

        return new AuthorDto(
            $rawIdentifier,
            $rawName,
            $active,
            $translates,
            $articles,
            $images
        );
    }

    /**
     * @param string $rawImages - Json encoded array of strings
     * @return array<int,ImageId>
     */
    protected function prepareRawImages(string $rawImages): array
    {
        $decodedImages = json_decode($rawImages);

        $data = [];
        foreach ($decodedImages as $image) {
            $data[] = new ImageId((string) $image);
        }
        return $data;
    }


    /**
     * @param string $rawArticles - Json encoded array of strings
     * @return array<int,ArticleId>
     */
    protected function prepareRawArticles(string $rawArticles): array
    {
        $decodedArticles = json_decode($rawArticles);

        $data = [];
        foreach ($decodedArticles as $article) {
            $data[] = new ArticleId($article);
        }
        return $data;
    }


    /** @throws RepositoryException */
    protected function createTranslates(string $rawId): array
    {
        $translates = [];

        $query = $this->translatesQuery();
        $params = [$rawId];

        try {
            $rows = $this->database->queryParams($query,$params);
        } catch(QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        foreach ($rows as $row) {
            $language = $row['language'] ?? null;
            if ($language === null) {
                throw new RepositoryException('Author translate languages is ivalid');
            }
            $description = $row['description'] ?? null;
            if ($description === null) {
                throw new RepositoryException('Author translate description is ivalid');
            }
            $translates[] = new Translate(
                new Identifier($language),
                new Description($description)
            );
        }

        return $translates;
    }

    protected function defaultQuery(): string
    {
        return <<<'QUERY'
        SELECT author.identifier,
            author.active,
            author.name,
            array_to_json (
                array (SELECT article.identifier 
                    FROM article
                    WHERE article.author_id = $1
                ) 
            ) as articles,
            array_to_json (
                array (SELECT img.identifier 
                    FROM img
                    WHERE img.author_id = $1
                ) 
            ) as images
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
