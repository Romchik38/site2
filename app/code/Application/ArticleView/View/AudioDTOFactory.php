<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleView\View;

final class AudioDTOFactory
{
    protected readonly string $pathPrefix;

    public function __construct(
        string $pathPrefix
    ) {
        if (str_ends_with($pathPrefix, '/')) {
            $this->pathPrefix = substr($pathPrefix, 0, strlen($pathPrefix) - 1);
        } else {
            $this->pathPrefix = $pathPrefix;
        }
    }

    public function create(
        string $path,
        string $description
    ): AudioDTO {
        if (str_starts_with($path, '/')) {
            $fullPath = $this->pathPrefix . $path;
        } else {
            $fullPath = sprintf('%s/%s', $this->pathPrefix, $path);
        }

        return new AudioDTO(
            $fullPath,
            $description
        );
    }
}
