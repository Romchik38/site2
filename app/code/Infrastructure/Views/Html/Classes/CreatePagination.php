<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Views\Html\Classes;

use Romchik38\Site2\Infrastructure\Views\CreatePaginationInterface;

final class CreatePagination implements CreatePaginationInterface
{
    public static function createHtml(
        int $page,
        int $limit,
        int $totalCount,
        int $displayed
    ): string {

        $remainder = $totalCount - $displayed;

        return <<<HTML
        <div>Displayed: {$displayed} </div>
        <div>Total: {$totalCount}</div>
        <div>Limit: {$limit}</div>
        <div>Remainder: {$remainder} </div>    
        HTML;
    }
}
