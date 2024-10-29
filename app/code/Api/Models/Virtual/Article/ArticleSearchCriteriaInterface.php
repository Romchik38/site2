<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\Virtual\Article;

use Romchik38\Server\Api\Models\SearchCriteria\SearchCriteriaInterface;

interface ArticleSearchCriteriaInterface extends SearchCriteriaInterface
{
    public function setActive(bool $value): self;
}
