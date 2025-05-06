<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\Translate\New\DefaultAction;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Site2\Application\Audio\AdminTranslateCreate\View\AudioRequirementsDto;
use Romchik38\Site2\Application\Audio\AdminTranslateCreate\View\TranslateDto;

final class ViewDto extends DefaultViewDTO
{
    /** @param array<int,string> $folders */
    public function __construct(
        string $name,
        string $description,
        public readonly TranslateDto $translateDto,
        public readonly string $csrfTokenField,
        public string $csrfToken,
        public readonly string $idFiled,
        public readonly string $languageFiled,
        public readonly string $descriptionField,
        public readonly string $fileField,
        public readonly string $folderField,
        public readonly array $folders,
        public readonly AudioRequirementsDto $audioRequirements
    ) {
        parent::__construct($name, $description);
    }
}
