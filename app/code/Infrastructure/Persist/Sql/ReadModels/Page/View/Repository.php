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
use Romchik38\Site2\Application\Page\View\View\ListDto;
use Romchik38\Site2\Application\Page\View\View\PageDto;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
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
        $url              = $searchCriteria->url;
        $urlString        = $url();
        $languageIdString = $searchCriteria->languageId;
        $query            = $this->findQuery();
        $params           = [
            $urlString,
            (string) $searchCriteria->languageId,
        ];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $count        = count($rows);
        $errorMessage = 'Page with url %s and language %s %s';
        if ($count === 0) {
            throw new NoSuchPageException(sprintf($errorMessage, $urlString, $languageIdString, 'not exist'));
        } elseif ($count > 1) {
            throw new RepositoryException(sprintf($errorMessage, $urlString, $languageIdString, 'has duplicates'));
        } else {
            return $this->createFromRow($rows[0], $url);
        }
    }

    public function list(LanguageId $languageId): array
    {
        $query  = $this->selectNamesQuery();
        $params = [$languageId()];
        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $dtos = [];
        foreach ($rows as $row) {
            $rawName = $row['name'] ?? null;
            if ($rawName === null) {
                throw new RepositoryException('Param page name is invalid');
            }
            $rawUrl = $row['url'] ?? null;
            if ($rawUrl === null) {
                throw new RepositoryException('Param page url is invalid');
            }
            try {
                $name   = new Name($rawName);
                $url    = new Url($rawUrl);
                $dtos[] = new ListDto($url, $name);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }
        }
        return $dtos;
    }

    /**
     * @throws RepositoryException
     * @param array<string,string|null> $row
     * */
    private function createFromRow(array $row, Url $url): PageDto
    {
        $rawId = $row['id'] ?? null;
        if ($rawId === null) {
            throw new RepositoryException('Page id is invalid');
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
            $id               = PageId::fromString($rawId);
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
        SELECT page.id,
            page_translates.name,
            page_translates.short_description,
            page_translates.description
        FROM page,
            page_translates
        WHERE page.url = $1 AND
            page.active = 't' AND
            page_translates.language = $2 AND
            page_translates.page_id = page.id
        QUERY;
    }

    private function selectNamesQuery(): string
    {
        return <<<'QUERY'
        SELECT page_translates.name,
            page.url
        FROM page_translates,
            page
        WHERE page_translates.language = $1 AND
            page_translates.page_id = page.id AND
            page.active = 't'
        QUERY;
    }
}
