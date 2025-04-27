<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\ImgConverter;

use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Application\Image\ImgConverter\View\Height;
use Romchik38\Site2\Application\Image\ImgConverter\View\ImgResult;
use Romchik38\Site2\Application\Image\ImgConverter\View\ImgViewRepositoryInterface;
use Romchik38\Site2\Application\Image\ImgConverter\View\Width;
use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Domain\Image\VO\Path;
use Romchik38\Site2\Domain\Image\VO\Type;

final class ImgConverterService
{
    public function __construct(
        protected readonly ImgViewRepositoryInterface $imgViewRepository,
        protected readonly ImageStorageInterface $imgConverter
    ) {
    }

    /**
     * @throws NoSuchEntityException
     * @throws CouldNotCreateImageException
     */
    public function createImg(ImgData $command): ImgResult
    {
        try {
            $image = $this->imgViewRepository->getById(Id::fromString($command->id));
        } catch (RepositoryException $e) {
            throw new CouldNotCreateImageException($e->getMessage());
        }

        return $this->imgConverter->makeCopy(
            $image->path(),
            Width::fromString($command->width),
            Height::fromString($command->height),
            new Type($command->type)
        );
    }

    public function createStub(StubData $command): ImgResult
    {
        $path = new Path($command->filePath);
        return $this->imgConverter->makeCopy(
            $path,
            Width::fromString($command->width),
            Height::fromString($command->height),
            new Type($command->type)
        );
    }
}
