<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\New\DefaultAction;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;

final class ViewDto extends DefaultViewDTO
{
    public function __construct(
        string $name,
        string $description,
        public readonly string $csrfTokenField,
        public string $csrfToken,
        public readonly string $nameFiled
    ) {
        parent::__construct($name, $description);
    }
}
