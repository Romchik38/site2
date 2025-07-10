<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\ContinueReading;

use DateTime;
use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Site2\Application\Article\ContinueReading\Commands\Find\SearchCriteria;
use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\NoSuchArticleException;
use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Article\ContinueReading\RepositoryInterface;
use Romchik38\Site2\Application\Article\ContinueReading\View\ArticleDto;
use Romchik38\Site2\Application\Article\ContinueReading\View\ImageDto;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Article\VO\Name as ArticleName;
use Romchik38\Site2\Domain\Article\VO\ShortDescription;
use Romchik38\Site2\Domain\Image\VO\Description as ImageDescription;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;

use function count;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private DatabaseSqlInterface $database
    ) {
    }

    public function find(SearchCriteria $searchCriteria): ArticleDto
    {
        $paramArticleId  = ($searchCriteria->articleId)();
        $paramLanguageId = ($searchCriteria->languageId)();
        $query           = $this->defaultQuery();
        $params          = [$paramLanguageId, $paramArticleId];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $count = count($rows);
        if ($count === 0) {
            throw new NoSuchArticleException(sprintf(
                'Article with given id %s and language %s not found',
                $paramArticleId,
                $paramLanguageId
            ));
        }
        if ($count > 1) {
            throw new RepositoryException(sprintf(
                'Article with given id %s and language %s has duplicates',
                $paramArticleId,
                $paramLanguageId
            ));
        }

        return $this->createFromRow($rows[0]);
    }

    /**
     * @throws RepositoryException
     * @param array<string,string|null> $row
     * */
    private function createFromRow(array $row): ArticleDto
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Article id is invalid');
        }
        $rawName = $row['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Article name is invalid');
        }
        $rawShortDescription = $row['short_description'] ?? null;
        if ($rawShortDescription === null) {
            throw new RepositoryException('Article short_description is invalid');
        }
        $rawCreatedAt = $row['created_at'] ?? null;
        if ($rawCreatedAt === null) {
            throw new RepositoryException('Article created at is invalid');
        }
        $rawImgId = $row['img_id'] ?? null;
        if ($rawImgId === null) {
            throw new RepositoryException('Article img id at is invalid');
        }
        $rawImgDescription = $row['img_description'] ?? null;
        if ($rawImgDescription === null) {
            throw new RepositoryException('Article img description at is invalid');
        }

        try {
            $articleId               = new ArticleId($rawIdentifier);
            $articleName             = new ArticleName($rawName);
            $articleShortDescription = new ShortDescription($rawShortDescription);
            $imageId                 = ImageId::fromString($rawImgId);
            $imageDescription        = new ImageDescription($rawImgDescription);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        return new ArticleDto(
            $articleId,
            $articleName,
            $articleShortDescription,
            new DateTime($rawCreatedAt),
            new ImageDto($imageId, $imageDescription)
        );
    }

    private function defaultQuery(): string
    {
        return <<<'QUERY'
        SELECT article.identifier,
            article.created_at,
            article_translates.name,
            article_translates.short_description,
            img_translates.img_id,
            img_translates.description as img_description
        FROM
            article,
            article_translates,
            img,
            img_translates
        WHERE 
            article.identifier = article_translates.article_id
            AND article.active = 'true'
            AND article_translates.language = $1
            AND article.img_id = img.identifier
            AND img_translates.img_id = article.img_id
            AND img_translates.language = $1
            AND article.identifier = $2
        QUERY;
    }
}
