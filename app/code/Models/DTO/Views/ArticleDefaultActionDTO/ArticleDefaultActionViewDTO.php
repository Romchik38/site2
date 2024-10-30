<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\DTO\Views\ArticleDefaultActionDTO;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;

/** @todo implement an interface */
final class ArticleDefaultActionViewDTO extends DefaultViewDTO {

    public function __construct(
        string $name, 
        string $description,
        protected array $articleList = []
    )
    {
        parent::__construct($name, $description);
    }

    /**
     * @todo replace with an interface 
     * @return ArticleDTO[] 
     * */
    public function getArticles(): array {
        return $this->articleList;
    }
}