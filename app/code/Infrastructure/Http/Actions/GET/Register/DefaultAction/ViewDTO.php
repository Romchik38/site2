<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Register\DefaultAction;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;

final class ViewDTO extends DefaultViewDTO
{
    public function __construct(
        string $name,
        string $description,
        public readonly ?string $adminUser
    ) {
        parent::__construct($name, $description);
    }
}
