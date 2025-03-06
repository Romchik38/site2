<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\Login\Admin\DefaultAction;

use Romchik38\Server\Controllers\Path;
use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;

final class ViewDTO extends DefaultViewDTO
{
    public function __construct(
        string $name, 
        string $description,
        public readonly ?string $adminUser,
        public readonly string $message,
        public readonly string $userNameField,
        public readonly string $passwordField,
        public readonly string $authUrl,
    )
    {
        parent::__construct($name, $description);
    }
}