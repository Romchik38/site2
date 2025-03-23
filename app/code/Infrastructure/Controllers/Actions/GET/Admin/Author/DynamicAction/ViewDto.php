<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Author\DynamicAction;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;
use Romchik38\Site2\Application\Author\AdminView\View\AuthorDto;

final class ViewDto extends DefaultViewDTO
{
    public function __construct(
        string $name,
        string $description,
        public readonly AuthorDto $authorDto,
        public readonly string $csrfTokenField,
        public string $csrfToken,
        public readonly string $idFiled,
        public readonly string $nameFiled,
        public readonly string $changeActivityFiled,
        public readonly string $yesField,
        public readonly string $noField,
        public readonly string $translateField,
        public readonly string $languageField,
        public readonly string $descriptionField
    ) {
        parent::__construct($name, $description);
    }
}
