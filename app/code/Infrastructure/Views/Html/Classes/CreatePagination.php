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
        if($displayed = $totalCount) return '';
        
        // Case 2: show pagination
               
        $firstElement = '';
        $middle = '';
        $last = '';
        // Curent page goes first
        if($page === 1) {
            $firstElement = '<div>1</div>';
        }

        $remainder = $totalCount - $displayed;

        $elements = [$firstElement, $middle, $last]; 

        return <<<HTML
        <div>Displayed: {$displayed} </div>
        <div>Total: {$totalCount}</div>
        <div>Limit: {$limit}</div>
        <div>Remainder: {$remainder} </div>    
        HTML;
    }
}
