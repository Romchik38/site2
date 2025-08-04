<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Search\Article\VO;

use InvalidArgumentException;
use Romchik38\Server\Domain\VO\Number\Number;

use function in_array;
use function sprintf;

final class Limit extends Number
{
    public const NAME = 'search limit';
    /** @todo replace with 15 */
    public const DEFAULT_LIMIT  = 5;
    public const ALLOWED_LIMITS = [5];

    public function __construct(
        int $value
    ) {
        if (in_array($value, self::ALLOWED_LIMITS) === false) {
            throw new InvalidArgumentException(
                sprintf('param %s %d is not allowed', $this::NAME, $value)
            );
        }
        parent::__construct($value);
    }

    public static function fromString(string $value): static
    {
        if ($value === '') {
            return new self(self::DEFAULT_LIMIT);
        } else {
            return parent::fromString($value);
        }
    }
}
