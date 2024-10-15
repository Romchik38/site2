<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\Link\Sql;

use Romchik38\Server\Models\Sql\Virtual\VirtualRepository;
use Romchik38\Site2\Api\Models\Link\Sql\LinkRepositoryInterface;

final class LinkRepository extends VirtualRepository implements LinkRepositoryInterface {

    public function getLinksByLanguageAndPaths(string $language, array $paths = []): array {
        $pathParts = [];
        $and = '';
        if (count($paths) > 0) {
            $and = ' AND ';
            $counter = 1;
            foreach($paths as $path) {
                $counter++;
                $pathParts[] = sprintf('links.path = $%s', $counter);
                $params[] = $path;
            }
        }
        $expresion = sprintf('WHERE links_translates.language = $1%s%s', $and, implode(' OR ', $pathParts));

        $params = [$language];

        $list = $this->list($expresion, $params);
        return $list;
    }

}