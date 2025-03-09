<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\Session;

use Romchik38\Server\Api\Services\SessionInterface;

interface Site2SessionInterface extends SessionInterface
{
    public const ADMIN_USER_FIELD = 'admin_user';
    public const USER_FIELD = 'user';
    public const MESSAGE_FIELD = 'message';
    public const CSRF_TOKEN_FIELD = 'csrf_token';
}