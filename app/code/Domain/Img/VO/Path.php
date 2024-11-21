<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Img\VO;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

final class Path
{
    protected function __construct(
        protected readonly string $path
    ) {}

    public static function fromString(string $path): self
    {
        if (strlen($path) === 0) {
            throw new InvalidArgumentException('param path is empty');
        }
        return new self($path);
    }

    public function __invoke(): string
    {
        return $this->path;
    }
}
