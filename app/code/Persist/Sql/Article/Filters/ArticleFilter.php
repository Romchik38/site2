<?php

declare(strict_types=1);

namespace Romchik38\Site2\Persist\Sql\Article\Filters;

use Romchik38\Site2\Persist\Sql\Article\ArticleRepository;

final class ArticleFilter
{

    private function __construct(
        protected readonly string $expression,
        protected readonly string $param
    ) {}

    public function getExpression(int $counter): string
    {
        return sprintf($this->expression, $counter);
    }

    public function getParam(): string {
        return $this->param;
    }

    public static function active(): self {
        $expression = sprintf(
            '%s.%s = $%%s', 
            ArticleRepository::ARTICLE_T,
            ArticleRepository::ARTICLE_C_ACTIVE
        );
        return new self(
            $expression,
            'true'
        );
    }
}
