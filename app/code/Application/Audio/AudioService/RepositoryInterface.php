<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AudioService;

use Romchik38\Site2\Domain\Audio\Audio;
use Romchik38\Site2\Domain\Audio\VO\Id;

interface RepositoryInterface
{
    /**
     * @throws NoSuchAudioException
     * @throws RepositoryException
     * */
    public function getById(Id $id): Audio;

    /**
     * @throws RepositoryException
     * */
    public function save(Audio $model): void;
}
