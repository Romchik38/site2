<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\ArticleTranslates;

use Romchik38\Server\Api\Models\ModelFactoryInterface;

interface ArticleTranslatesFactoryInterface extends ModelFactoryInterface
{
    public function create(): ArticleTranslatesInterface;
}
