<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Img\DefaultAction;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

final class ImgData
{
    public const URL_FIELD = 'url';
    public const URL_prefix = 'media/img/id';
    protected readonly string $imgId;
    protected readonly string $imgAspectRatioWidth;
    protected readonly string $imgAspectRatioHeight;
    protected readonly string $imgSize;
    protected readonly string $imgType;

    /** @param string $url /media/img/id/1/1-1/576.webp */
    public function __construct(
        protected readonly string $url
    ) {
        if ($url === '') throw new InvalidArgumentException('param url is empty');
        $parts = explode('/', $url);
        if (count($parts) !== 7) throw new InvalidArgumentException('param url has too many parts');
        $urlPrefix = sprintf('%s/%s/%s', $parts[1], $parts[2], $parts[3]);
        if ($urlPrefix !== $this::URL_prefix) throw new InvalidArgumentException('param url is invalid');

        $this->imgId = (string)(int)$parts[4];

        $aspectRatioParts = explode('-', $parts[5]);
        if (count($aspectRatioParts) !== 2) throw new InvalidArgumentException('param url is invalid');
        $this->imgAspectRatioWidth = $aspectRatioParts[0];
        $this->imgAspectRatioHeight = $aspectRatioParts[1];

        $imageNameParts = explode('.', $parts[6]);
        if (count($imageNameParts) !== 2) throw new InvalidArgumentException('param url is invalid');
        $this->imgSize = $imageNameParts[0];
        $this->imgType = $imageNameParts[1];
    }

    public static function fromRequest(array $hash): self
    {
        return new ImgData(
            $hash[self::URL_FIELD] ?? '',
        );
    }
}
