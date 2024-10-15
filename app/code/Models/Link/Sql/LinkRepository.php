<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\Link\Sql;

use Romchik38\Server\Models\Sql\Repository;
use Romchik38\Site2\Api\Models\Link\Sql\LinkRepositoryInterface;

final class LinkRepository extends Repository implements LinkRepositoryInterface {
    public function getLinksByLanguage(string $language): array {
        $expresion = 'WHERE ';
        $params = [$language];
        $list = $this->list($expresion, $params);
        return $list;
    }
}