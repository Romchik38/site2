<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminView\Dto;

use Romchik38\Site2\Domain\Audio\VO\Id as AudioId;
use Romchik38\Site2\Domain\Audio\VO\Name;

final readonly class AudioDto
{
    /** @param array<int,AudioTranslateDto> $translates */
    public function __construct(
        public AudioId $id,
        public bool $active,
        public Name $name,
        public array $translates
    ) {
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public function getName(): string
    {
        return (string) $this->name;
    }
}
