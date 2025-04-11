<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AdminView;

use Romchik38\Site2\Domain\Audio\VO\Id as AudioId;
use Romchik38\Site2\Application\Author\AdminView\View\AudioDto;

interface RepositoryInterface
{
    /**
     * @throws NoSuchAudioException
     * @throws RepositoryException
     * */
    public function getById(AudioId $id): AudioDto;
}
