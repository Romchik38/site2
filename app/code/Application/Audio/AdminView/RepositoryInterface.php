<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AdminView;

use Romchik38\Site2\Application\Audio\AdminView\View\AudioDto;
use Romchik38\Site2\Domain\Audio\VO\Id as AudioId;

interface RepositoryInterface
{
    /**
     * @throws NoSuchAudioException
     * @throws RepositoryException
     * */
    public function getById(AudioId $id): AudioDto;
}
