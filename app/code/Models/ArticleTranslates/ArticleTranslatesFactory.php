<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\ArticleTranslates;

use Romchik38\Server\Models\ModelFactory;
use Romchik38\Site2\Api\Models\ArticleTranslates\ArticleTranslatesFactoryInterface;
use Romchik38\Site2\Api\Models\ArticleTranslates\ArticleTranslatesInterface;

final class ArticleTranslatesFactory extends ModelFactory implements ArticleTranslatesFactoryInterface
{
    public function create(): ArticleTranslatesInterface
    {
        return new ArticleTranslates();
    }
}
