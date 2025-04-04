<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\ImageService;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Image\ImageRepositoryInterface;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;
use Romchik38\Site2\Domain\Image\RepositoryException;

final class ImageService
{
    public function __construct(
        private readonly ImageRepositoryInterface $repository
    ) {   
    }

    /** 
     * @throws CouldNotUpdateException
     * @throws InvalidArgumentException
     */
    public function update(Update $command): void
    {
        $imageId = ImageId::fromString($command->id);
        try {
            $model = $this->repository->getById($imageId);
        } catch (RepositoryException $e) {
            throw new CouldNotUpdateException($e->getMessage());
        }

        // do update
        $name = $command->name;
    }
}
