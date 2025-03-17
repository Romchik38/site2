<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\AdminArticleListView;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Models\Sql\SearchCriteria\OrderBy;
use Romchik38\Site2\Application\Article\AdminArticleListView\RepositoryException;
use Romchik38\Site2\Application\Article\AdminArticleListView\RepositoryInterface;
use Romchik38\Site2\Application\Article\AdminArticleListView\SearchCriteria;
use Romchik38\Site2\Application\Article\AdminArticleListView\View\ArticleDto;

final class Repository implements RepositoryInterface
{
    public function __construct(
        protected readonly DatabaseInterface $database
    ) {  
    }

    public function list(SearchCriteria $searchCriteria): array
    {
        $expression = [];
        $params = [];
        $paramCount = 0;

        /** ORDER BY */
        $orderBy = new OrderBy(
            ($searchCriteria->orderByField)(),
            ($searchCriteria->orderByDirection)()
        );

        $expression[] = sprintf(
            'ORDER BY %s %s %s',
            $orderBy->getField(),
            $orderBy->getDirection(),
            $orderBy->getNulls()
        );

        /** LIMIT */
        $expression[] = sprintf('LIMIT $%s', ++$paramCount);
        $params[] = ($searchCriteria->limit)();

        /** OFFSET */
        $expression[] = sprintf('OFFSET $%s', ++$paramCount);
        $params[] = $searchCriteria->offset->toString();

        $query = sprintf('%s %s', $this->defaultQuery(), implode(' ', $expression));

        $rows = $this->database->queryParams($query, $params);

        $models = [];

        foreach ($rows as $row) {
            $models[] = $this->createFromRow($row);
        }
        return $models;
    }

    /** @param array<string,string> $row */
    protected function createFromRow(array $row): ArticleDto
    {
        /** @todo */

        $rawIdentifier = $row['identifier'] ?? null;
        if($rawIdentifier === null) {
            throw new RepositoryException('Article id is ivalid');
        }

        $rawActive = $row['active']  ?? null;
        if($rawActive === null) {
            throw new RepositoryException('Article active is ivalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        $rawImgActive = $row['img_active']  ?? null;
        if ($rawImgActive === null) {
            $imageActive = null;
        } else {
            if ($rawImgActive === 't') {
                $imageActive = true;
            } else {
                $imageActive = false;
            }
        }

        $rawAudioActive = $row['audio_active']  ?? null;
        if ($rawAudioActive === null) {
            $audioActive = null;
        } else {
            if ($rawAudioActive === 't') {
                $audioActive = true;
            } else {
                $audioActive = false;
            }
        }

        $rawAuthorName = $row['author_name']  ?? null;
        if ($rawAuthorName === null) {
            throw new RepositoryException('Article author name is ivalid');
        }

        $articleDTO = new ArticleDto(
            $rawIdentifier,
            $active,
            $imageActive,
            $row['img_id']  ?? null,
            $audioActive,
            $rawAuthorName
        );

        return $articleDTO;
    }
    
    protected function defaultQuery(): string
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

    public function totalCount(): int
    {
        $query = 'SELECT count(article.identifier) as count FROM article';

        $rows = $this->database->queryParams($query, []);

        $firstElem = $rows[0];
        $count = $firstElem['count'];

        return (int)$count;
    }
}
