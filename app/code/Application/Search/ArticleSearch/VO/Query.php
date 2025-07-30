<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Search\ArticleSearch\VO;

use Romchik38\Server\Domain\VO\Text\NonEmpty;

final class Query extends NonEmpty
{
    // ^[\p{L}\p{N} ]{1,255}$
    public function __construct(
        string $value
    ) {

        parent::__construct($value);   
    }
}