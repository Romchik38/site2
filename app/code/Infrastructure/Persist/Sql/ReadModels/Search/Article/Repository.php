<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Search\Article;

use DateTime;
use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Site2\Application\Search\Article\Commands\List\SearchCriteria;
use Romchik38\Site2\Application\Search\Article\Commands\List\SearchResult;
use Romchik38\Site2\Application\Search\Article\RepositoryException;
use Romchik38\Site2\Application\Search\Article\RepositoryInterface;
use Romchik38\Site2\Application\Search\Article\View\ArticleDto;
use Romchik38\Site2\Application\Search\Article\View\AuthorDto;
use Romchik38\Site2\Application\Search\Article\View\ImageDto;
use Romchik38\Site2\Application\Search\Article\VO\TotalCount;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Article\VO\Name as ArticleName;
use Romchik38\Site2\Domain\Article\VO\ShortDescription;
use Romchik38\Site2\Domain\Author\VO\Description as AuthorDescription;
use Romchik38\Site2\Domain\Image\VO\Description as ImageDescription;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;
use Romchik38\Site2\Domain\Image\VO\Path;

use function count;
use function explode;
use function implode;
use function sprintf;

final class Repository implements RepositoryInterface
{
    private const LANGUAGE_CONFIGURATION = [
        'en' => 'english',
        'uk' => 'ukrainian',
    ];

    public function __construct(
        private DatabaseSqlInterface $database
    ) {
    }

    public function list(SearchCriteria $searchCriteria): SearchResult
    {
        // 1 - tsv configuration
        // 2 - tsv query
        // 3 - language
        $params = [];

        $language      = (string) $searchCriteria->languageId;
        $configuration = $this::LANGUAGE_CONFIGURATION[$language] ?? null;
        if ($configuration === null) {
            throw new RepositoryException(sprintf(
                'Language configuration for %s not exist',
                $language
            ));
        }
        $params[] = $configuration;

        $tsvQuery = $this->renderTsvQuery((string) $searchCriteria->query);
        $params[] = $tsvQuery;

        $params[] = $language;
        $params[] = (string) $searchCriteria->offset;
        $params[] = (string) $searchCriteria->limit;

        $databaseQuery = $this->listWithRowsQuery();

        try {
            $rows = $this->database->queryParams($databaseQuery, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $models = [];

        foreach ($rows as $row) {
            $models[] = $this->createFromRow($row);
        }

        if (count($rows) === 0) {
            $rawTotalCount = '0';
        } else {
            $rawTotalCount = $row['total_count'] ?? null;
            if ($rawTotalCount === null) {
                throw new RepositoryException('Article total count is invalid');
            }
        }

        try {
            $totalCount = TotalCount::fromString($rawTotalCount);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        return new SearchResult($models, $totalCount);
    }

    /**
     * @throws RepositoryException
     * @param array<string,string|null> $row
     * */
    private function createFromRow(array $row): ArticleDto
    {
        // Article
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Article id is invalid');
        }
        $rawCreatedAt = $row['created_at'] ?? null;
        if ($rawCreatedAt === null) {
            throw new RepositoryException('Article created at is invalid');
        }
        $rawName = $row['article_name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Article name is invalid');
        }
        $rawShortDescription = $row['short_description'] ?? null;
        if ($rawShortDescription === null) {
            throw new RepositoryException('Article short_description is invalid');
        }

        // Image
        $rawImgId = $row['img_id'] ?? null;
        if ($rawImgId === null) {
            throw new RepositoryException('Article img id at is invalid');
        }
        $rawImgDescription = $row['img_description'] ?? null;
        if ($rawImgDescription === null) {
            throw new RepositoryException('Article img description at is invalid');
        }
        $rawImgPath = $row['path'] ?? null;
        if ($rawImgPath === null) {
            throw new RepositoryException('Article img path at is invalid');
        }

        // Author
        $rawAuthorDescription = $row['author_description'] ?? null;
        if ($rawAuthorDescription === null) {
            throw new RepositoryException('Article author description is invalid');
        }

        try {
            $articleId         = new ArticleId($rawIdentifier);
            $articleName       = new ArticleName($rawName);
            $shortDescription  = new ShortDescription($rawShortDescription);
            $imageId           = ImageId::fromString($rawImgId);
            $imageDescription  = new ImageDescription($rawImgDescription);
            $imagePath         = new Path($rawImgPath);
            $authorDescription = new AuthorDescription($rawAuthorDescription);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        return new ArticleDto(
            $articleId,
            new DateTime($rawCreatedAt),
            $articleName,
            $shortDescription,
            new AuthorDto($authorDescription),
            new ImageDto($imageId, $imageDescription, $imagePath),
        );
    }

    private function renderTsvQuery(string $value): string
    {
        return implode(
            ' & ',
            explode(' ', $value)
        );
    }

    /** @todo remove */
    // private function listQuery(): string
    // {
    //     return <<<'QUERY'
    //     SELECT article.identifier,
    //         article.created_at,
    //         article.img_id,
    //         article_translates.name as article_name,
    //         article_translates.short_description,
    //         author_translates.description as author_description,
    //         img_translates.description as img_description,
    //         img.path,
    //         ts_rank(
    //             tsv,
    //             to_tsquery($1, $2)
    //         ) as rank
    //     FROM article_translates,
    //         article,
    //         author_translates,
    //         author,
    //         img,
    //         img_translates
    //     WHERE article_translates.language = $3 AND
    //         (
    //             tsv @@ to_tsquery($1, $2)
    //         ) AND
    //         article.active = 't' AND
    //         article.identifier = article_translates.article_id AND
    //         article.author_id = author.identifier AND
    //         article.img_id = img.identifier AND

    //         author.identifier = author_translates.author_id AND
    //         author.active = 't' AND
    //         author_translates.language = $3 AND

    //         img.active = 't' AND
    //         img.identifier = img_translates.img_id AND
    //         img_translates.language = $3
    //     ORDER BY rank DESC;
    //     QUERY;
    // }

    /** makes pre-select of all matches and then returns total count and a limit bunch of articles */
    private function listWithRowsQuery(): string
    {
        return <<<'QUERY'
        WITH rows AS (
            SELECT article.identifier,
            article.created_at,
            article.img_id,
            article_translates.name as article_name,
            article_translates.short_description,
            author_translates.description as author_description,
            img_translates.description as img_description,
            img.path,
            ts_rank(
                tsv,
                to_tsquery($1, $2)
            ) as rank
            FROM article_translates,
                article,
                author_translates,
                author,
                img,
                img_translates
            WHERE article_translates.language = $3 AND 
                (
                    tsv @@ to_tsquery($1, $2)
                ) AND
                article.active = 't' AND
                article.identifier = article_translates.article_id AND
                article.author_id = author.identifier AND
                article.img_id = img.identifier AND
                author.identifier = author_translates.author_id AND
                author.active = 't' AND
                author_translates.language = $3 AND
                img.active = 't' AND
                img.identifier = img_translates.img_id AND
                img_translates.language = $3
            ORDER BY rank DESC
        )
        SELECT rows.*,
            COUNT(*) OVER () AS total_count
        FROM rows 
        OFFSET $4 LIMIT $5; 
        QUERY;
    }
}
