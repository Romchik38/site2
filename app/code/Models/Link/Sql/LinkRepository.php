<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\Link\Sql;

use Romchik38\Server\Models\Sql\Virtual\VirtualRepository;
use Romchik38\Site2\Api\Models\Link\Sql\LinkRepositoryInterface;

final class LinkRepository extends VirtualRepository implements LinkRepositoryInterface {

    public function getLinksByLanguageAndPaths(string $language, array $paths): array {
        $expresion = 'WHERE ';

        $params = [$language];

        $list = $this->list($expresion, $params);
        return $list;
    }

}