<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\DTO\Views\Article\DefaultAction;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;
use Romchik38\Site2\Api\Models\DTO\Views\Article\DefaultAction\ViewDTOInterface;

final class ViewDTO extends DefaultViewDTO implements ViewDTOInterface
{
    public function __construct(
        string $name,
        string $description,
        protected array $articleList = []
    ) {
        parent::__construct($name, $description);
    }

    public function getArticles(): array
    {
        return $this->articleList;
    }
}
