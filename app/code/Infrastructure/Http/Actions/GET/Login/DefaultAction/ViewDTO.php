<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Login\DefaultAction;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Site2\Application\Page\View\View\PageDto;

final class ViewDTO extends DefaultViewDTO
{
    public function __construct(
        string $name,
        string $description,
        public readonly ?string $user,
        public readonly string $emailField,
        public readonly string $passwordField,
        public readonly string $csrfTokenField,
        public readonly string $csrfToken,
        public readonly PageDto $page
    ) {
        parent::__construct($name, $description);
    }
}
