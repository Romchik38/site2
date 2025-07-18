<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\User\VO;

use InvalidArgumentException;
use Romchik38\Server\Domain\VO\Text\Text;

use function preg_match;

final class Password extends Text
{
    public const NAME = 'User password';
    /** @todo move field to command */
    public const FIELD         = 'password';
    public const PATTERN       = '^(?=.*[_`$%^*\'])(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[A-Za-z0-9_`$%^*\']{8,}$';
    public const ERROR_MESSAGE = 'Password must be at least 8 characters long'
        . ', contain at least one lowercase, uppercase letter, number and a '
        . 'specal character from _`$%^*\'';

    /** @throws InvalidArgumentException */
    public function __construct(
        string $value
    ) {
        $check = preg_match('/' . $this::PATTERN . '/', $value);
        if ($check === 0 || $check === false) {
            throw new InvalidArgumentException($this::ERROR_MESSAGE);
        }
        parent::__construct($value);
    }
}
