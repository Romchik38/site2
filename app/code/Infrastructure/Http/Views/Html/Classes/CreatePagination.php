<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Views\Html\Classes;

use InvalidArgumentException;
use Romchik38\Site2\Infrastructure\Http\Views\Html\CreatePaginationInterface;
use Romchik38\Site2\Infrastructure\Http\Views\Html\UrlGeneratorInterface;

use function array_merge;
use function ceil;
use function htmlspecialchars;
use function sprintf;

/**
 * It is responsable for creating HTML pagination block
 * */
final class CreatePagination implements CreatePaginationInterface
{
    /** @var array<int,Query> */
    private array $queries;

    /**
     * @param array<int,mixed|Query> $queries
     * @throws InvalidArgumentException
     * */
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly int $displayed,
        private readonly int $limit,
        private readonly string $limitFieldName,
        private readonly int $page,
        private readonly string $pageFieldName,
        private readonly int $totalCount,
        array $queries,
        private readonly int $maxPageToShow = 5,
        private readonly string $marker = '...'
    ) {
        if ($displayed < 0) {
            throw new InvalidArgumentException(sprintf(
                'Pagination param displayed %s is invalid',
                $displayed
            ));
        }
        if ($limit < 0) {
            throw new InvalidArgumentException(sprintf(
                'Pagination param limit %s is invalid',
                $limit
            ));
        }
        if ($page < 0) {
            throw new InvalidArgumentException(sprintf(
                'Pagination param page %s is invalid',
                $page
            ));
        }
        if ($totalCount < 0) {
            throw new InvalidArgumentException(sprintf(
                'Pagination param totalCount %s is invalid',
                $totalCount
            ));
        }
        foreach ($queries as $query) {
            if (! $query instanceof Query) {
                throw new InvalidArgumentException('Parm query is invalid');
            }
        }
        $this->queries = $queries;
    }

    public function create(): string
    {
        // Case 1: do not show pagination
        if ($this->displayed === $this->totalCount) {
            return '';
        }

        // Case 2: show pagination
        $first       = '';
        $middle      = '';
        $last        = '';
        $remainder   = $this->totalCount - $this->displayed;
        $maxNextPage = $this->maxPageToShow;
        $totalPages  = (int) ceil($this->totalCount / $this->limit);

        // Case FIRST
        if ($this->page === 1) {
            $first = $this->activeLink(1);
            if ($remainder > 0) {
                if ($totalPages < $maxNextPage) {
                    $maxNextPage = $totalPages;
                }
                for ($i = 1; $i <= $maxNextPage; $i++) {
                    if (($this->page + $i) > $totalPages) {
                        break;
                    }
                    $middle = sprintf('%s%s', $middle, $this->link($this->page + $i));
                }
                if ($totalPages > $maxNextPage) {
                    $last = sprintf('%s%s', $this->chainBreak(), $this->link($totalPages));
                }
            }
        } elseif ($this->page === $totalPages) {
            // Case LAST
            $last = $this->activeLink($this->page);
            if ($totalPages < $maxNextPage) {
                $maxNextPage = $totalPages;
            }
            for ($i = 1; $i <= $maxNextPage; $i++) {
                if (($totalPages - $i) === 0) {
                    break;
                }
                $middle = sprintf('%s%s', $this->link($totalPages - $i), $middle);
            }
            if ($totalPages > $maxNextPage) {
                $first = sprintf('%s%s', $this->link(1), $this->chainBreak());
            }
        } else {
            // Case MIDDLE
            $first       = $this->link(1);
            $last        = $this->link($totalPages);
            $maxNextPage = (int) ceil($maxNextPage / 2);
            // Fill left
            $counter     = 0;
            $currentPage = $this->page - 1;
            while ($currentPage > 1) {
                $middle = $this->link($currentPage) . $middle;
                $counter++;
                $currentPage--;
                if ($counter === $maxNextPage) {
                    if ($currentPage !== 1) {
                        $middle = $this->chainBreak() . $middle;
                    }
                    break;
                }
            }
            // Fill center
            $middle .= $this->activeLink($this->page);
            // Fill right
            $counter     = 0;
            $currentPage = $this->page + 1;
            while ($currentPage < $totalPages) {
                $middle .= $this->link($currentPage);
                $counter++;
                $currentPage++;
                if ($counter === $maxNextPage) {
                    if ($currentPage !== $totalPages) {
                        $middle .= $this->chainBreak();
                    }
                    break;
                }
            }
        }

        return sprintf('%s%s%s', $first, $middle, $last);
    }

    private function activeLink(int $pageNumber): string
    {
        return sprintf(
            '<li class="page-item active disabled"><a class="page-link" href="#">%s</a></li>',
            $pageNumber
        );
    }

    private function link(int $pageNumber): string
    {
        $link = $this->glueLink((string) $pageNumber);
        return sprintf(
            '<li class="page-item"><a class="page-link" href="%s">%s</a></li>',
            htmlspecialchars($link),
            $pageNumber
        );
    }

    private function chainBreak(): string
    {
        return sprintf(
            '<li class="page-item"><a class="page-link" href="#">%s</a></li>',
            $this->marker
        );
    }

    private function glueLink(string $part): string
    {
        $queryArr = array_merge(
            [
                new Query($this->pageFieldName, $part),
                new Query($this->limitFieldName, (string) $this->limit),
            ],
            $this->queries
        );
        return $this->urlGenerator->generateUrl($queryArr);
    }
}
