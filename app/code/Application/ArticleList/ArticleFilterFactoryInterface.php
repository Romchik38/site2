<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Api\Article;

use Romchik38\Server\Api\Models\SearchCriteria\FilterInterface;

interface ArticleFilterFactoryInterface
{
    public static function active(): FilterInterface;
}
