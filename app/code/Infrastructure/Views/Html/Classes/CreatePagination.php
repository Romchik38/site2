<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Views\Html\Classes;

use Romchik38\Site2\Infrastructure\Views\CreatePaginationInterface;

/** It is responsable for creating HTML pagination block */
final class CreatePagination implements CreatePaginationInterface
{
    
    public static function createPagination(
        int $page,
        int $limit,
        int $totalCount,
        int $displayed
    ): string {

        // Case 1: do not show pagination
        if($displayed === $totalCount) return '';
        
        // Case 2: show pagination       
        $firstElement = '';
        $middle = '';
        $last = '';
        $dots = '<div>...</div>';
        $remainder = $totalCount - $displayed;
        $maxNextPage = 5;
        $totalPages = (int)ceil($totalCount / $limit);

        // FIRST
        if($page === 1) {
            $firstElement = '<div>1</div>';
            if($remainder > 0) {
                if($totalPages < $maxNextPage) {
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
            // LAST
            $last = sprintf('<div>%s</div>', $page);
            if($totalPages < $maxNextPage) {
                $maxNextPage = $totalPages;
            }
            for($i = 1; $i <= $maxNextPage; $i++) {
                if(($totalPages-$i) === 0) break;
                $middle = sprintf('<div>%s</div>%s', $totalPages-$i, $middle);
            }
            if($totalPages > $maxNextPage) {
                $firstElement = sprintf('<div>1</div>%s', $dots);
            }
        } else {
            // MIDDLE
        }
    

        return sprintf('%s%s%s', $firstElement, $middle, $last);
        // return <<<HTML
        // <div>Displayed: {$displayed} </div>
        // <div>Total: {$totalCount}</div>
        // <div>Limit: {$limit}</div>
        // <div>Remainder: {$remainder} </div>    
        // HTML;
    }
}
