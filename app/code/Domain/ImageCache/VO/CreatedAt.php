<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\ImageCache\VO;

use DateTime;
use DateTimeImmutable;
use Romchik38\Server\Models\Errors\InvalidArgumentException;

final class CreatedAt
{
    protected const DEFAULT_FORMAT = 'Y-m-d H:i:s';

    public function __construct(
        protected readonly DateTime $createdAt
    ) {}

    public static function fromString(string $datetime): self
    {
        if (strlen($datetime) === 0) {
            throw new InvalidArgumentException('param createdAt is empty');
        }
        try {
            $date = new DateTime($datetime);
        } catch (\Exception) {
            throw new InvalidArgumentException('param createdAt is invalid');
        }
        return new self($date);
    }

    public function __invoke(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromMutable($this->createdAt);
    }

    public function toString(): string
    {
        return $this->createdAt->format(self::DEFAULT_FORMAT);
    }
}
