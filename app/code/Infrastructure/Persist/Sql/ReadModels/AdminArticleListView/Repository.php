<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\AdminArticleListView;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Models\Sql\SearchCriteria\Limit;
use Romchik38\Server\Models\Sql\SearchCriteria\Offset;
use Romchik38\Server\Models\Sql\SearchCriteria\OrderBy;
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
        $params[] = $searchCriteria->limit->toString();

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
        $articleDTO = new ArticleDto(
            $row['identifier'] ?? '',
            $row['active']  ?? '',
            $row['author_id']  ?? '',
            $row['img_id']  ?? '',
            $row['audio_id']  ?? ''
        );

        return $articleDTO;
    }
    
    protected function defaultQuery(): string
    {
        return <<<QUERY
        SELECT article.identifier,
            article.active,
            article.author_id,
            article.img_id,
            article.audio_id,
        FROM article
        QUERY;
    }
}
