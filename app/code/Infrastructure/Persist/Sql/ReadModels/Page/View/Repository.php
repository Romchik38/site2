<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Page\View;

use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Site2\Application\Page\View\Commands\Find\SearchCriteria;
use Romchik38\Site2\Application\Page\View\NoSuchPageException;
use Romchik38\Site2\Application\Page\View\RepositoryException;
use Romchik38\Site2\Application\Page\View\RepositoryInterface;
use Romchik38\Site2\Application\Page\View\View\PageDto;
use Romchik38\Site2\Domain\Page\VO\Description;
use Romchik38\Site2\Domain\Page\VO\Id as PageId;
use Romchik38\Site2\Domain\Page\VO\Name;
use Romchik38\Site2\Domain\Page\VO\ShortDescription;
use Romchik38\Site2\Domain\Page\VO\Url;

use function count;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function find(SearchCriteria $searchCriteria): PageDto
    {
        $id     = $searchCriteria->pageId;
        $idInt  = $id();
        $query  = $this->findQuery();
        $params = [
            $idInt,
            (string) $searchCriteria->languageId,
        ];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $count = count($rows);
        if ($count === 0) {
            throw new NoSuchPageException(sprintf('Page with id %d not exist', $idInt));
        } elseif ($count > 1) {
            throw new RepositoryException(sprintf('Page with id %d has duplicates', $idInt));
        } else {
            return $this->createFromRow($rows[0], $id);
        }
    }

    /**
     * @throws RepositoryException
     * @param array<string,string|null> $row
     * */
    private function createFromRow(array $row, PageId $id): PageDto
    {
        $rawUrl = $row['url'] ?? null;
        if ($rawUrl === null) {
            throw new RepositoryException('Page url is invalid');
        }

        $rawShortDescription = $row['short_description'] ?? null;
        if ($rawShortDescription === null) {
            throw new RepositoryException('Page short description param is invalid');
        }
        $rawDescription = $row['description'] ?? null;
        if ($rawDescription === null) {
            throw new RepositoryException('Page description param is invalid');
        }
        $rawName = $row['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Page name param is invalid');
        }

        try {
            $url              = new Url($rawUrl);
            $name             = new Name($rawName);
            $shortDescription = new ShortDescription($rawShortDescription);
            $description      = new Description($rawDescription);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        return new PageDto($id, $url, $name, $shortDescription, $description);
    }

    private function findQuery(): string
    {
        return <<<'QUERY'
        SELECT page.url,
            page_translates.name,
            page_translates.short_description,
            page_translates.description
        FROM page,
            page_translates
        WHERE page_translates.page_id = $1 AND
            page_translates.language = $2 AND
            page_translates.page_id = page.id AND
            page.active = 't'
        QUERY;
    }
}
