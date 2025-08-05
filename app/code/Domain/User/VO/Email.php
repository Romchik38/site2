<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\User\VO;

use InvalidArgumentException;
use Romchik38\Server\Domain\VO\Text\Text;

use function preg_match;

final class Email extends Text
{
    public const NAME    = 'User email';
    public const PATTERN = '^[A-Za-z0-9.]{2,}@[A-Za-z0-9.]{2,}\.[a-z]{2,}$';
    /** Email Local Part can contain latin characters, numbers and a dot. Domain can contain latin characters and a dot, must end minimun with 2 characters after a dot */
    public const ERROR_MESSAGE = 'user.email-error';

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
