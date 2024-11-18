<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\Link;

use Romchik38\Server\Models\Sql\Virtual\VirtualRepository;
use Romchik38\Site2\Domain\Link\LinkInterface;
use Romchik38\Site2\Domain\Link\LinkRepositoryInterface;

final class LinkRepository extends VirtualRepository implements LinkRepositoryInterface
{

    public function getLinksByLanguageAndPaths(string $language, array $paths = []): array
    {
        $params = [$language];

        $pathParts = [];
        $and = '';
        /** 1. Select by paths */
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
            $expresion = sprintf('WHERE links.link_id = links_translates.link_id AND links_translates.language = $1%s(%s)', $and, implode(' OR ', $pathParts));
        } else {
            /** Select all by language */
            $expresion = 'WHERE links.link_id = links_translates.link_id AND links_translates.language = $1';
        }

        /** @var LinkInterface[] $list */
        $list = $this->list($expresion, $params);

        return $list;
    }
}
