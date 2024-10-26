<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\Virtual\Article;

use Romchik38\Server\Api\Models\ModelFactoryInterface;

interface ArticleFactoryInterface extends ModelFactoryInterface
{
    public function create(): ArticleInterface;
}
