<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\SimilarArticles\Commands\ListSimilar;

use function array_push;
use function gettype;

final class ListSimilar
{
    /** @var array<int,string> $categories */
    public readonly array $categories;

    /**
     * @param array<int,string|mixed> $categories
     */
    public function __construct(
        public readonly string $articleId,
        array $categories,
        public readonly string $language
    ) {
        $arr = [];
        foreach ($categories as $category) {
            if (gettype($category) !== 'string') {
                array_push($arr, '');
            } else {
                array_push($arr, $category);
            }
        }
        $this->categories = $arr;
    }
}
