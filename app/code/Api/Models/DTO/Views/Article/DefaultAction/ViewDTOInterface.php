<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\DTO\Views\Article\DefaultAction;

use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOInterface;

interface ViewDTOInterface extends DefaultViewDTOInterface {

    /**
     * @return ArticleDTO[] 
     * */
    public function getArticles(): array;
}