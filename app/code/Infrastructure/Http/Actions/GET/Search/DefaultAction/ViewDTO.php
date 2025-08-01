<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Search\DefaultAction;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Site2\Application\Search\Article\Commands\List\ListCommand;
use Romchik38\Site2\Application\Search\Article\View\ArticleDto;

final class ViewDTO extends DefaultViewDTO
{
    /** @param array<int,ArticleDTO> $articleList */
    public function __construct(
        string $name,
        string $description,
        public readonly array $articleList,
        public readonly ?string $query
    ) {
        parent::__construct($name, $description);
    }

    public function getQueryField(): string
    {
        return ListCommand::QUERY_FILED;
    }
}
