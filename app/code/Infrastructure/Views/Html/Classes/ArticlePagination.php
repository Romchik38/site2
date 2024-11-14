<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Views\Html\Classes;

use Romchik38\Server\Api\Services\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Infrastructure\Controllers\Article\DefaultAction\Pagination;
use Romchik38\Site2\Infrastructure\Views\CreatePaginationInterface;

/**
 * @todo move to server abstract part
 * It is responsable for creating HTML pagination block 
 * */
final class ArticlePagination implements CreatePaginationInterface
{
    protected readonly int $page;
    protected readonly int $limit;
    protected readonly int $totalCount;
    protected readonly string $suffix;
    protected readonly string $postfix;

    public function __construct(
        protected readonly UrlbuilderInterface $urlbuilder,
        protected readonly Pagination $pagination,
        protected readonly int $displayed,
        protected readonly int $maxPageToShow = 5,
        protected readonly string $marker = '...'
    ) {
        $this->page = (int)$pagination->page();
        $this->limit = (int)$pagination->limit();
        $this->totalCount = $pagination->totalCount();

        $this->suffix = $this->urlbuilder->add(sprintf(
            '?%s=',
            $pagination::PAGE_FIELD
        ));

        $this->postfix = sprintf('&%s=%s&%s=%s&%s=%s',
            $pagination::LIMIT_FIELD,
            $pagination->limit(),
            $pagination::ORDER_BY_FIELD,
            $pagination->orderByField(),
            $pagination::ORDER_BY_DIRECTION_FIELD,
            $pagination->orderByDirection()
        );
    }

    public function create(): string
    {

        // Case 1: do not show pagination
        if ($this->displayed === $this->totalCount) return '';

        // Case 2: show pagination       
        $first = '';
        $middle = '';
        $last = '';
        $remainder = $this->totalCount - $this->displayed;
        $maxNextPage = $this->maxPageToShow;
        $totalPages = (int)ceil($this->totalCount / $this->limit);

        // Case FIRST
        if ($this->page === 1) {
            $first = $this->activeLink(1);
            if ($remainder > 0) {
                if ($totalPages < ($maxNextPage)) {
                    $maxNextPage = $totalPages;
                }
                for ($i = 1; $i <= $maxNextPage; $i++) {
                    if (($this->page + $i) > $totalPages) break;
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
                if (($totalPages - $i) === 0) break;
                $middle = sprintf('%s%s', $this->link($totalPages - $i), $middle);
            }
            if ($totalPages > $maxNextPage) {
                $first = sprintf('%s%s', $this->link(1), $this->chainBreak());
            }
        } else {
            // Case MIDDLE
            $first = $this->link(1);
            $last = $this->link($totalPages);
            $maxNextPage = (int)ceil($maxNextPage / 2);
            // Fill left
            $counter = 0;
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
            $middle = $middle . $this->activeLink($this->page);
            // Fill right
            $counter = 0;
            $currentPage = $this->page + 1;
            while ($currentPage < $totalPages) {
                $middle = $middle . $this->link($currentPage);
                $counter++;
                $currentPage++;
                if ($counter === $maxNextPage) {
                    if ($currentPage !== $totalPages) {
                        $middle = $middle . $this->chainBreak();
                    }
                    break;
                }
            }
        }

        return sprintf('%s%s%s', $first, $middle, $last);
    }

    protected function activeLink(int $pageNumber): string
    {
        $link = $this->glueLink((string)$pageNumber);
        return sprintf(
            '<li class="page-item active disabled"><a class="page-link" href="#">%s</a></li>',
            $pageNumber
        );
    }

    protected function link(int $pageNumber): string
    {
        $link = $this->glueLink((string)$pageNumber);
        return sprintf(
            '<li class="page-item"><a class="page-link" href="%s">%s</a></li>',
            htmlspecialchars($link),
            $pageNumber
        );
    }

    protected function chainBreak(): string
    {

        return sprintf(
            '<li class="page-item"><a class="page-link" href="#">%s</a></li>',
            $this->marker
        );
    }

    protected function glueLink(string $part): string {
        return sprintf(
            '%s%s%s',
            $this->suffix,
            $part,
            $this->postfix
        );
    }
}
