<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\AdminList\Commands\Filter\VO;

use InvalidArgumentException;
use Romchik38\Server\Domain\VO\Number\Number;

use function sprintf;

final class Offset extends Number
{
    public const NAME = 'page offset';

    /** @throws InvalidArgumentException */
    public function __construct(
        int $offset
    ) {
        if ($offset < 0) {
            throw new InvalidArgumentException(sprintf('param %s %d is invalid', $this::NAME, $offset));
        }
        parent::__construct($offset);
    }
}
