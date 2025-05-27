<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\DynamicAction;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Site2\Application\Language\List\View\LanguageDto;
use Romchik38\Site2\Application\Article\AdminView\Dto\ArticleDto;

final class ViewDto extends DefaultViewDTO
{
    /** @param array<int,LanguageDto> $languages */
    public function __construct(
        string $name,
        string $description,
        public readonly string $csrfTokenField,
        public string $csrfToken,
        public readonly array $languages,
        public readonly ArticleDto $article
    ) {
        parent::__construct($name, $description);
    }
}
