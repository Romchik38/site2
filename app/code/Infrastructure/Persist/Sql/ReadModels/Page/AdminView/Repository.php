<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Page\AdminView;

use InvalidArgumentException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Server\Persist\Sql\QueryException;
use Romchik38\Site2\Application\Page\AdminView\NoSuchPageException;
use Romchik38\Site2\Application\Page\AdminView\RepositoryException;
use Romchik38\Site2\Application\Page\AdminView\RepositoryInterface;
use Romchik38\Site2\Application\Page\AdminView\View\PageDto;
use Romchik38\Site2\Application\Page\AdminView\View\TranslateDto;
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

    public function getById(PageId $id): PageDto
    {
        $query  = $this->getByIdQuery();
        $params = [$id()];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $count = count($rows);
        if ($count === 0) {
            throw new NoSuchPageException(sprintf('Page with id %d not exist', $id()));
        } elseif ($count > 1) {
            throw new RepositoryException(sprintf('Page with id %d has duplicates', $id()));
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
        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Page active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        $rawUrl = $row['url'] ?? null;
        if ($rawUrl === null) {
            throw new RepositoryException('Page url is invalid');
        }

        $translates = $this->createTranslates($id);

        try {
            $url = new Url($rawUrl);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        return new PageDto($id, $active, $url, $translates);
    }

    /** @return array<int,TranslateDto> */
    private function createTranslates(PageId $id): array
    {
        $query  = $this->translatesQuery();
        $params = [$id()];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $translates = [];
        foreach ($rows as $row) {
            $rawLanguage = $row['language'] ?? null;
            if ($rawLanguage === null) {
                throw new RepositoryException('Page translate language param is invalid');
            }
            $rawShortDescription = $row['short_description'] ?? null;
            if ($rawShortDescription === null) {
                throw new RepositoryException('Page translate short description param is invalid');
            }
            $rawDescription = $row['description'] ?? null;
            if ($rawDescription === null) {
                throw new RepositoryException('Page translate description param is invalid');
            }
            $rawName = $row['name'] ?? null;
            if ($rawName === null) {
                throw new RepositoryException('Page translate name param is invalid');
            }

            try {
                $translates[] = new TranslateDto(
                    new LanguageId($rawLanguage),
                    new Name($rawName),
                    new ShortDescription($rawShortDescription),
                    new Description($rawDescription)
                );
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException('Page admin view repository error:' . $e->getMessage());
            }
        }

        return $translates;
    }

    private function getByIdQuery(): string
    {
        return <<<'QUERY'
        SELECT page.id,
            page.active,
            page.url
        FROM page
        WHERE page.id = $1
        QUERY;
    }

    private function translatesQuery(): string
    {
        return <<<'QUERY'
        SELECT page_translates.language,
            page_translates.name,
            page_translates.short_description,
            page_translates.description
        FROM page_translates
        WHERE page_translates.page_id = $1
        QUERY;
    }
}
