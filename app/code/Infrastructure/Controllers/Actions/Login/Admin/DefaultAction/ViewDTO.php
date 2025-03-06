<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\Login\Admin\DefaultAction;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;

final class ViewDTO extends DefaultViewDTO
{
    public function __construct(
        string $name, 
        string $description,
        protected readonly ?string $adminUser
    )
    {
        parent::__construct($name, $description);
    }
}