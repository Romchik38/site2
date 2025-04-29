<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\AdminListView;

use InvalidArgumentException;
use Romchik38\Server\Models\Errors\QueryException;
use Romchik38\Server\Models\Sql\DatabaseSqlInterface;
use Romchik38\Server\Models\Sql\SearchCriteria\OrderBy;
use Romchik38\Site2\Application\Article\AdminList\Commands\Filter\SearchCriteria;
use Romchik38\Site2\Application\Article\AdminList\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Article\AdminList\RepositoryInterface;
use Romchik38\Site2\Application\Article\AdminList\View\ArticleDto;
use Romchik38\Site2\Domain\Image\VO\Id;

use function implode;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function list(SearchCriteria $searchCriteria): array
    {
        $expression = [];
        $params     = [];
        $paramCount = 0;

        /** ORDER BY */
        try {
            $orderBy = new OrderBy(
                ($searchCriteria->orderByField)(),
                ($searchCriteria->orderByDirection)()
            );
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $expression[] = sprintf(
            'ORDER BY %s %s %s',
            $orderBy->getField(),
            $orderBy->getDirection(),
            $orderBy->getNulls()
        );

        /** LIMIT */
        $expression[] = sprintf('LIMIT $%s', ++$paramCount);
        $params[]     = ($searchCriteria->limit)();

        /** OFFSET */
        $expression[] = sprintf('OFFSET $%s', ++$paramCount);
        $params[]     = (string) $searchCriteria->offset;

        $query = sprintf('%s %s', $this->defaultQuery(), implode(' ', $expression));

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $models = [];

        foreach ($rows as $row) {
            $models[] = $this->createFromRow($row);
        }
        return $models;
    }

    public function totalCount(): int
    {
        $query = 'SELECT count(article.identifier) as count FROM article';

        try {
            $rows = $this->database->queryParams($query, []);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $firstElem = $rows[0];
        $count     = $firstElem['count'];

        return (int) $count;
    }

    /**
     * @throws RepositoryException
     * @param array<string,string> $row
     * */
    private function createFromRow(array $row): ArticleDto
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Article id is invalid');
        }

        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Article active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        $rawImgActive = $row['img_active'] ?? null;
        if ($rawImgActive === null) {
            $imageActive = null;
        } else {
            if ($rawImgActive === 't') {
                $imageActive = true;
            } else {
                $imageActive = false;
            }
        }

        $rawAudioActive = $row['audio_active'] ?? null;
        if ($rawAudioActive === null) {
            $audioActive = null;
        } else {
            if ($rawAudioActive === 't') {
                $audioActive = true;
            } else {
                $audioActive = false;
            }
        }

        $rawAuthorName = $row['author_name'] ?? null;
        if ($rawAuthorName === null) {
            throw new RepositoryException('Article author name is invalid');
        }

        $rawImageId = $row['img_id'] ?? null;
        if ($rawImageId !== null) {
            try {
                $imageId = Id::fromString($rawImageId);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }
        } else {
            $imageId = $rawImageId;
        }

        return new ArticleDto(
            $rawIdentifier,
            $active,
            $imageActive,
            $imageId,
            $audioActive,
            $rawAuthorName
        );
    }

    private function defaultQuery(): string
    {
        return <<<QUERY
        SELECT article.identifier,
            article.active,
            article.img_id,
            (SELECT img.active 
                FROM img WHERE img.identifier = article.img_id
            ) as img_active,
            (SELECT audio.active 
                FROM audio WHERE audio.identifier = article.audio_id
            ) as audio_active,
            (SELECT author.name 
                FROM author WHERE author.identifier = article.author_id
            ) as author_name
        FROM article 
        QUERY;
    }
}
