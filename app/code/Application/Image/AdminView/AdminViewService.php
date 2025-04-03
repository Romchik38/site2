<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminView;

use Romchik38\Site2\Domain\Image\NoSuchImageException;
use Romchik38\Site2\Domain\Image\VO\Id;

use function sprintf;

final class AdminViewService
{
    public function __construct(
        private readonly RepositoryInterface $repository,
        private readonly string $imgPathPrefix,
        private readonly ImageMetadataLoaderInterface $loader
    ) {
    }

    /**
     * @throws NoSuchImageException
     * @throws CouldNotFindException
     */
    public function find(Id $id): Result
    {
        try {
            $image = $this->repository->getById($id);
        } catch (RepositoryException $e) {
            throw new CouldNotFindException($e->getMessage());
        }

        $path        = (string) $image->path;
        $imgFullPath = sprintf(
            '%s/%s',
            $this->imgPathPrefix,
            $path
        );

        try {
            $metadata = $this->loader->loadMetadata($imgFullPath);
        } catch (CouldNotLoadImageMetadataException $e) {
            throw new CouldNotFindException($e->getMessage());
        }

        return new Result($image, $metadata);
    }
}
