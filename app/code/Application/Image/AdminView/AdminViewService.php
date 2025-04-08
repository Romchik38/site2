<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminView;

use Romchik38\Site2\Application\Image\AdminView\View\AuthorDto;
use Romchik38\Site2\Application\Image\AdminView\View\ImageRequirementsDto;
use Romchik38\Site2\Domain\Image\NoSuchImageException;
use Romchik38\Site2\Domain\Image\VO\Height;
use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Domain\Image\VO\Size;
use Romchik38\Site2\Domain\Image\VO\Type;
use Romchik38\Site2\Domain\Image\VO\Width;

use function sprintf;

final class AdminViewService
{
    public function __construct(
        private readonly RepositoryInterface $repository,
        private readonly string $imgPathPrefix,
        private readonly ImageMetadataLoaderInterface $loader,
        private readonly string $imgPathPrefixFrontend,
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
            $metadata = $this->loader->createMetadataDto($imgFullPath);
        } catch (CouldNotLoadImageMetadataException $e) {
            throw new CouldNotFindException($e->getMessage());
        }

        $imageFrontendPath = sprintf(
            '%s/%s',
            $this->imgPathPrefixFrontend,
            $path
        );

        return new Result($image, $metadata, $imageFrontendPath);
    }

    /**
     * @throws RepositoryException
     * @return array<int,AuthorDto>
     */
    public function listAuthors(): array
    {
        return $this->repository->listAuthors();
    }

    public function imageRequirements(): ImageRequirementsDto
    {
        return new ImageRequirementsDto(
            Width::MIN_VALUE,
            Height::MIN_VALUE,
            Size::MAX_VALUE,
            Type::ALLOWED_TYPES
        );
    }
}
