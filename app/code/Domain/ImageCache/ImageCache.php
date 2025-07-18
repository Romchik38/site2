<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\ImageCache;

use DateTime;
use Romchik38\Site2\Domain\ImageCache\VO\Data;
use Romchik38\Site2\Domain\ImageCache\VO\Key;
use Romchik38\Site2\Domain\ImageCache\VO\Type;

final class ImageCache
{
    public const SAVE_DATE_FORMAT = 'Y-m-d H:i:s';

    public function __construct(
        readonly Key $key,
        readonly Data $data,
        readonly Type $type,
        readonly DateTime $createdAt
    ) {
    }

    public static function create(Key $key, Data $data, Type $type): self
    {
        return new self(
            $key,
            $data,
            $type,
            new DateTime()
        );
    }

    public function formatCreatedAt(): string
    {
        return $this->createdAt->format(self::SAVE_DATE_FORMAT);
    }
}
