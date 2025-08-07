<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\User\VO;

use JsonSerializable;
use Romchik38\Server\Domain\VO\Text\NonEmpty;

final class Username extends NonEmpty implements JsonSerializable
{
    public const NAME = 'user username';

    public function jsonSerialize(): string
    {
        /** @todo refactor when $value will be protected */
        return (string) $this;
    }
}
