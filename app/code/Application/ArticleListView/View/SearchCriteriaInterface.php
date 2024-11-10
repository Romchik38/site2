<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleListView\View;

interface SearchCriteriaInterface
{
    public function offset(): string;
    public function limit(): string;
    public function orderBy(): string;
    public function language(): string;
}
