<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Views\Html\Classes;

use Romchik38\Site2\Infrastructure\Views\CreatePaginationInterface;

/** It is responsable for creating HTML pagination block */
final class CreatePagination implements CreatePaginationInterface
{
    
    public static function createHtml(
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
        $maxNextPage = 2;

        // FIRST
        if($page === 1) {
            $firstElement = '<div>1</div>';
        }
        if($remainder > 0) {
            $totalPages = (int)ceil($totalCount / $limit);
            for($i = 2; $i <= $maxNextPage; $i++) {
                $middle = sprintf('%s <div>%s</div>', $middle, $i);
            }
            if($totalPages > $maxNextPage) {
                $last = sprintf('%s <div>%s</div>', $dots, $totalPages);
            }
        }

        // MIDDLE
        // LAST

        return sprintf('%s%s%s', $firstElement, $middle, $last);
        // return <<<HTML
        // <div>Displayed: {$displayed} </div>
        // <div>Total: {$totalCount}</div>
        // <div>Limit: {$limit}</div>
        // <div>Remainder: {$remainder} </div>    
        // HTML;
    }
}
