<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AdminList\View;

use Romchik38\Site2\Domain\Audio\VO\Id;
use Romchik38\Site2\Domain\Audio\VO\Name;

final readonly class AudioDto
{
    public function __construct(
        public Id $id,
        public bool $active,
        public Name $name
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'audio_id'     => ($this->id)(),
            'audio_active' => $this->active,
            'audio_name'   => ($this->name)(),
        ];
    }
}
