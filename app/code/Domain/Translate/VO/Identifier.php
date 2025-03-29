<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Translate\VO;

use Romchik38\Server\Controllers\Name;

final class Identifier extends Name
{
    public const NAME = 'Translate_Identifier';

    public function __construct(
        protected readonly string $id
    ) {
        parent::__construct($id);
    }

    public function __invoke(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
