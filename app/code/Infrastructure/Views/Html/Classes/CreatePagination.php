<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Views\Html\Classes;

use Romchik38\Site2\Infrastructure\Views\CreatePaginationInterface;

/** It is responsable for creating HTML pagination block */
final class CreatePagination implements CreatePaginationInterface
{
    public function __construct(
        protected readonly int $maxPageToShow = 5,
        protected readonly string $marker = '...'
    ) {}

    public function create(
        int $page,
        int $limit,
        int $totalCount,
        int $displayed
    ): string {

        // Case 1: do not show pagination
        if ($displayed === $totalCount) return '';

        // Case 2: show pagination       
        $first = '';
        $middle = '';
        $last = '';
        $remainder = $totalCount - $displayed;
        $maxNextPage = $this->maxPageToShow;
        $totalPages = (int)ceil($totalCount / $limit);

        // Case FIRST
        if ($page === 1) {
            $first = $this->activeLink(1);
            if ($remainder > 0) {
                if ($totalPages < ($maxNextPage)) {
                    $maxNextPage = $totalPages;
                }
                for ($i = 1; $i <= $maxNextPage; $i++) {
                    if (($page + $i) > $totalPages) break;
                    $middle = sprintf('%s%s', $middle, $this->link($page + $i));
                }
                if ($totalPages > $maxNextPage) {
                    $last = sprintf('%s%s', $this->chainBreak(), $this->link($totalPages));
                }
            }
        } elseif ($page === $totalPages) {
            // Case LAST
            $last = $this->activeLink($page);
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
            $currentPage = $page - 1;
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
            $middle = $middle . $this->activeLink($page);
            // Fill right
            $counter = 0;
            $currentPage = $page + 1;
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

    protected function activeLink(int $pageNumber): string {
        
        return sprintf(
            '<li class="page-item active"><a class="page-link" href="#">%s</a></li>',
            $pageNumber
        ); 
    }

    protected function link(int $pageNumber): string {
        
        return sprintf(
            '<li class="page-item"><a class="page-link" href="#">%s</a></li>',
            $pageNumber
        ); 
    }

    protected function chainBreak(): string {
        
        return sprintf(
            '<li class="page-item"><a class="page-link" href="#">%s</a></li>',
            $this->marker
        ); 
    }
}
