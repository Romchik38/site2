<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminVisitor\VO;

use InvalidArgumentException;
use Romchik38\Server\Domain\VO\Text\NonEmpty;

use function sprintf;
use function strlen;

final class CsrfToken extends NonEmpty
{
    public const NAME                 = 'admin visitor csrf token';
    public const LENGTH               = 32;
    public const LENGTH_ERROR_MESSAGE = 'param %s %s is invalid';

    /** @throws InvalidArgumentException */
    public function __construct(
        string $value
    ) {
        if (strlen($value) < $this::LENGTH) {
            throw new InvalidArgumentException(sprintf($this::LENGTH_ERROR_MESSAGE, $this::NAME, $value));
        }
        parent::__construct($value);
    }
}
