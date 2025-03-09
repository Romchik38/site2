<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Login\DefaultAction;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;

final class ViewDTO extends DefaultViewDTO
{
    public function __construct(
        string $name, 
        string $description,
        public readonly ?string $user,
        public readonly string $message
    )
    {
        parent::__construct($name, $description);
    }
}