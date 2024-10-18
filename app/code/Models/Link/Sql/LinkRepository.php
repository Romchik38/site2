<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\Link\Sql;

use Romchik38\Server\Models\Sql\Virtual\VirtualRepository;
use Romchik38\Site2\Api\Models\Virtual\Link\Sql\LinkRepositoryInterface;

final class LinkRepository extends VirtualRepository implements LinkRepositoryInterface
{

    public function getLinksByLanguageAndPaths(string $language, array $paths = []): array
    {
        $params = [$language];

        $pathParts = [];
        $and = '';
        if (count($paths) > 0) {
            $and = ' AND ';
            $counter = 1;
            foreach ($paths as $path) {
                $counter++;
                $pathParts[] = sprintf('links.path = $%s', $counter);
                // like {"root"}
                $params[] = sprintf(
                    '{%s}',
                    implode(',', array_map(fn($val) => sprintf('"%s"', $val), $path))
                );
            }
        }

        $expresion = sprintf('WHERE links.link_id = links_translates.link_id AND links_translates.language = $1%s(%s)', $and, implode(' OR ', $pathParts));

        /** @var \Romchik38\Site2\Api\Models\Virtual\Link\LinkInterface[] $list */
        $list = $this->list($expresion, $params);

        return $list;
    }
}
