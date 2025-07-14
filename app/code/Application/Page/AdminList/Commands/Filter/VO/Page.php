<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\AdminList\Commands\Filter\VO;

use Romchik38\Server\Domain\VO\Number\Positive;

final class Page extends Positive
{
    public const NAME         = 'page page';
    public const DEFAULT_PAGE = 1;

    public static function fromString(string $page): static
    {
        if ($page === '') {
            return new self(self::DEFAULT_PAGE);
        } else {
            $p = parent::fromString($page);
            return new self($p());
        }
    }
}
