<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Views\Html\Classes;

use Romchik38\Site2\Infrastructure\Views\CreatePaginationInterface;

/** It is responsable for creating HTML pagination block */
final class CreatePagination implements CreatePaginationInterface
{
    public function __construct(
        protected readonly int $maxPageToShow = 5
    )
    {
        
    }
    public function createPagination(
        int $page,
        int $limit,
        int $totalCount,
        int $displayed
    ): string {

        // Case 1: do not show pagination
        if($displayed === $totalCount) return '';
        
        // Case 2: show pagination       
        $first = '';
        $middle = '';
        $last = '';
        $dots = '<div>...</div>';
        $remainder = $totalCount - $displayed;
        $maxNextPage = $this->maxPageToShow;
        $totalPages = (int)ceil($totalCount / $limit);

        // Case FIRST
        if($page === 1) {
            $first = '<div>1</div>';
            if($remainder > 0) {
                if($totalPages < ($maxNextPage)) {
                    $maxNextPage = $totalPages;
                }
                for($i = 1; $i <= $maxNextPage; $i++) {
                    if(($page + $i) > $totalPages) break;
                    $middle = sprintf('%s<div>%s</div>', $middle, $page + $i);
                }
                if($totalPages > $maxNextPage) {
                    $last = sprintf('%s<div>%s</div>', $dots, $totalPages);
                }
            }
        } elseif($page === $totalPages) {
            // Case LAST
            $last = sprintf('<div>%s</div>', $page);
            if($totalPages < $maxNextPage) {
                $maxNextPage = $totalPages;
            }
            for($i = 1; $i <= $maxNextPage; $i++) {
                if(($totalPages-$i) === 0) break;
                $middle = sprintf('<div>%s</div>%s', $totalPages-$i, $middle);
            }
            if($totalPages > $maxNextPage) {
                $first = sprintf('<div>1</div>%s', $dots);
            }
        } else {
            // Case MIDDLE
            $first = '<div>1</div>';
            $last = sprintf('<div>%s</div>', $totalPages);
            $maxNextPage = (int)ceil($maxNextPage / 2);
            // Fill left
            $counter = 0;            
            $currentPage = $page - 1;
            while($currentPage > 1) {
                $middle = sprintf('<div>%s</div>%s', $currentPage, $middle);
                $counter++;
                $currentPage--;
                if($counter === $maxNextPage) {
                    if($currentPage !== 1) {
                        $middle = sprintf('%s%s', $dots, $middle);
                    }
                    break;
                }
            }
            // Fill center 
            $middle = sprintf('%s<div>%s</div>', $middle, $page);
            // Fill right
            $counter = 0;            
            $currentPage = $page + 1;
            while($currentPage < $totalPages) {
                $middle = sprintf('%s<div>%s</div>', $middle, $currentPage);
                $counter++;
                $currentPage++;
                if($counter === $maxNextPage) {
                    if($currentPage !== $totalPages) {
                        $middle = sprintf('%s%s', $middle, $dots);
                    }
                    break;
                }
            }            
        }
    
        return sprintf('%s%s%s', $first, $middle, $last);
    }
}
