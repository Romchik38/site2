<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Audio\Translate\DefaultAction;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;
use Romchik38\Site2\Application\Audio\AdminTranslateView\View\TranslateDto;

final class ViewDto extends DefaultViewDTO
{
    public function __construct(
        string $name,
        string $description,
        public readonly TranslateDto $translateDto,
        public readonly string $csrfTokenField,
        public string $csrfToken,
        public readonly string $idFiled,
        public readonly string $languageFiled,
        public readonly string $descriptionField,
        public readonly string $audioPathPrefix
    ) {
        parent::__construct($name, $description);
    }
}
