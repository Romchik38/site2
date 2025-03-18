<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Images\DefaultAction;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;

final class ViewDto extends DefaultViewDTO
{
    public function __construct(
        string $name, 
        string $description
    ) {
        parent::__construct($name, $description);
    }
}