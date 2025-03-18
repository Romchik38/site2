<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\ImgConverter;

use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Application\Image\ImgConverter\View\Height;
use Romchik38\Site2\Application\Image\ImgConverter\View\ImgResult;
use Romchik38\Site2\Application\Image\ImgConverter\View\ImgViewRepositoryInterface;
use Romchik38\Site2\Application\Image\ImgConverter\View\Type;
use Romchik38\Site2\Application\Image\ImgConverter\View\Width;
use Romchik38\Site2\Domain\Image\VO\Id;

final class ImgConverterService
{

    public function __construct(
        protected readonly ImgViewRepositoryInterface $imgViewRepository,
        protected readonly string $imgPathPrefix,
        protected readonly ImgConverterInterface $imgConverter
    ) {}

    /** 
     * @throws NoSuchEntityException
     * @throws CouldNotCreateImageException
     */
    public function createImg(ImgData $command): ImgResult
    {
        $img = $this->imgViewRepository->getById(new Id($command->id));
        $imgFullPath = sprintf(
            '%s/%s',
            $this->imgPathPrefix,
            ($img->path())()
        );

        $imgResult = $this->imgConverter->create(
            $imgFullPath,
            Width::fromString($command->width),
            Height::fromString($command->height),
            Type::fromString($command->type)
        );

        return $imgResult;
    }

    public function createStub(StubData $command): ImgResult
    {
        $imgResult = $this->imgConverter->create(
            $command->filePath,
            Width::fromString($command->width),
            Height::fromString($command->height),
            Type::fromString($command->type)
        );

        return $imgResult;
    }
}
