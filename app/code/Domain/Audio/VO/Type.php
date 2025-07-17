<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Audio\VO;

use InvalidArgumentException;
use Romchik38\Server\Domain\VO\Text\Text;

use function in_array;
use function sprintf;

final class Type extends Text
{
    public const NAME = 'Audio type';

    /** All audio must be only these types */
    public const ALLOWED_TYPES = ['mp3'];

    /** @throws InvalidArgumentException */
    public function __construct(
        string $value
    ) {
        if (! in_array($value, self::ALLOWED_TYPES)) {
            throw new InvalidArgumentException(sprintf(
                'param %s %s is invalid',
                self::NAME,
                $value
            ));
        }
        parent::__construct($value);
    }
}
