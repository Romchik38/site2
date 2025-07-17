<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminUser\VO;

use InvalidArgumentException;
use Romchik38\Server\Domain\VO\Text\Text;

use function preg_match;

final class Username extends Text
{
    public const NAME = 'Admin user username';
    /** @todo move to command */
    public const FIELD         = 'user_name';
    public const PATTERN       = '^[A-Za-z0-9_]{3,20}$';
    public const ERROR_MESSAGE = 'Username must be 3-20 characters long'
        . ', can contain lowercase, uppercase letter, number and underscore. '
        . 'Case-Sensitive';

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
