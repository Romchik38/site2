<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\DefaultAction;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Site2\Application\Article\AdminList\View\ArticleDto;

final class ViewDto extends DefaultViewDTO
{
    /** @param array<int,ArticleDto> $articleList */
    public function __construct(
        string $name,
        string $description,
        public readonly array $articleList,
        public readonly string $paginationHtml,
        public readonly PaginationForm $paginationForm
    ) {
        parent::__construct($name, $description);
    }
}
