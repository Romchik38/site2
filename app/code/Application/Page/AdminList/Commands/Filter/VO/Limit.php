<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\AdminList\Commands\Filter\VO;

use InvalidArgumentException;
use Romchik38\Server\Domain\VO\Number\Number;

use function in_array;
use function sprintf;

final class Limit extends Number
{
    public const NAME           = 'page limit';
    public const DEFAULT_LIMIT  = 30;
    public const ALLOWED_LIMITS = [15, 30, 60];

    /** @throws InvalidArgumentException */
    public function __construct(
        int $limit
    ) {
        if (in_array($limit, self::ALLOWED_LIMITS) === false) {
            throw new InvalidArgumentException(sprintf('param $s %s is not allowed', $limit));
        }
        parent::__construct($limit);
    }

    public static function fromString(string $limit): static
    {
        if ($limit === '') {
            return new self(self::DEFAULT_LIMIT);
        } else {
            $p = parent::fromString($limit);
            return new self($p());
        }
    }
}
