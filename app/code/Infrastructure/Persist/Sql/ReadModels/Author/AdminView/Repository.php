<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Author\AdminView;

use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Site2\Application\Author\AdminView\NoSuchAuthorException;
use Romchik38\Site2\Application\Author\AdminView\RepositoryException;
use Romchik38\Site2\Application\Author\AdminView\RepositoryInterface;
use Romchik38\Site2\Application\Author\AdminView\View\ArticleDto;
use Romchik38\Site2\Application\Author\AdminView\View\AuthorDto;
use Romchik38\Site2\Application\Author\AdminView\View\ImageDto;
use Romchik38\Site2\Application\Author\AdminView\View\Translate;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Description;
use Romchik38\Site2\Domain\Author\VO\Name;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;
use Romchik38\Site2\Domain\Language\VO\Identifier;

use function count;
use function json_decode;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function getById(AuthorId $id): AuthorDto
    {
        $idAsString = $id();
        $params     = [$idAsString];

        $query = $this->defaultQuery();

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $rowCount = count($rows);
        if ($rowCount === 0) {
            throw new NoSuchAuthorException(sprintf(
                'Author with id %s not exist',
                $idAsString
            ));
        }
        if ($rowCount > 1) {
            throw new RepositoryException(sprintf(
                'Author with id %s has duplicates',
                $idAsString
            ));
        }

        $firstRow = $rows[0];
        return $this->createFromRow($firstRow);
    }

    /** @param array<string,string|null> $row */
    private function createFromRow(array $row): AuthorDto
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Author id is invalid');
        }

        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Author active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        $rawName = $row['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Author name is invalid');
        }

        $translates = $this->createTranslates($rawIdentifier);

        $rawArticles = $row['articles'] ?? null;
        if ($rawArticles === null) {
            throw new RepositoryException('Author articles is invalid');
        }

        $rawImages = $row['images'] ?? null;
        if ($rawImages === null) {
            throw new RepositoryException('Author images is invalid');
        }

        try {
            $id       = AuthorId::fromString($rawIdentifier);
            $name     = new Name($rawName);
            $articles = $this->prepareRawArticles($rawArticles);
            $images   = $this->prepareRawImages($rawImages);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        return new AuthorDto(
            $id,
            $name,
            $active,
            $translates,
            $articles,
            $images
        );
    }

    /**
     * @throws InvalidArgumentException
     * @param string $rawImages - Json encoded array of strings
     * @return array<int,ImageDto>
     */
    private function prepareRawImages(string $rawImages): array
    {
        $decodedImages = json_decode($rawImages);

        $data = [];
        foreach ($decodedImages as $image) {
            $data[] = new ImageDto(new ImageId($image));
        }
        return $data;
    }

    /**
     * @param string $rawArticles - Json encoded array of strings
     * @return array<int,ArticleDto>
     */
    private function prepareRawArticles(string $rawArticles): array
    {
        $decodedArticles = json_decode($rawArticles);

        $data = [];
        foreach ($decodedArticles as $article) {
            $data[] = new ArticleDto(new ArticleId($article));
        }
        return $data;
    }

    /**
     * @throws RepositoryException
     * @return array<int,Translate>
     * */
    private function createTranslates(string $rawId): array
    {
        $translates = [];

        $query  = $this->translatesQuery();
        $params = [$rawId];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        foreach ($rows as $row) {
            $language = $row['language'] ?? null;
            if ($language === null) {
                throw new RepositoryException('Author translate languages is invalid');
            }
            $description = $row['description'] ?? null;
            if ($description === null) {
                throw new RepositoryException('Author translate description is invalid');
            }
            $translates[] = new Translate(
                new Identifier($language),
                new Description($description)
            );
        }

        return $translates;
    }

    private function defaultQuery(): string
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

    private function translatesQuery(): string
    {
        return <<<'QUERY'
        SELECT author_translates.language,
            author_translates.description
        FROM author_translates
        WHERE author_translates.author_id = $1
        QUERY;
    }
}
