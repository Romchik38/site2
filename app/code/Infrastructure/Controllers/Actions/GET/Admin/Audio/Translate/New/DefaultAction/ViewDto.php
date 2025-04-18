<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Audio\Translate\New\DefaultAction;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;

/** @todo implemend after app service */
final class ViewDto extends DefaultViewDTO
{
    public function __construct(
        string $name,
        string $description,
        public readonly string $csrfTokenField,
        public string $csrfToken,
        public readonly string $idFiled,
        public readonly string $languageFiled,
        public readonly string $descriptionField
    ) {
        parent::__construct($name, $description);
    }
}
