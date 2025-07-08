<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\MostVisited\DefaultAction;

use DateTime;
use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Site2\Application\Article\AdminMostVisited\Views\ArticleDTO;

final class ViewDto extends DefaultViewDTO
{
    /** @param array<int,ArticleDto> $articleList */
    public function __construct(
        string $name,
        string $description,
        public readonly array $articleList,
        public readonly string $csrfTokenField,
        public readonly string $csrfToken
    ) {
        parent::__construct($name, $description);
    }

    public function formatDate(DateTime $date): string
    {
        return $date->format('d-m-Y');
    }
}
