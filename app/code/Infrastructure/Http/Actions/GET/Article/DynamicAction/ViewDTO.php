<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Article\DynamicAction;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;
use Romchik38\Site2\Application\Article\View\View\ArticleViewDTO;

final class ViewDTO extends DefaultViewDTO
{
    public function __construct(
        string $name,
        string $description,
        public readonly ArticleViewDTO $article,
    ) {
        parent::__construct($name, $description);
    }
}
