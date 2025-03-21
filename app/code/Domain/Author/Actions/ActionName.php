<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Author\Actions;

use InvalidArgumentException;

final class ActionName
{
    public const array ACTIONS = ['update', 'delete', 'add'];
    public const ACTION_DELETE = 'delete';
    public const ACTION_UPDATE = 'update';
    public const ACTION_ADD = 'add';

    public function __construct(
        public readonly string $name
    ) {
        if (! in_array($name, self::ACTIONS)) {
            throw new InvalidArgumentException('Action name is empty');
        }
    }

    public function __invoke(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
