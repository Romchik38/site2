<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImgConverter;

use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Server\Services\Errors\FileLoaderException;
use Romchik38\Site2\Application\ImgConverter\View\AspectRatio;
use Romchik38\Site2\Application\ImgConverter\View\Height;
use Romchik38\Site2\Application\ImgConverter\View\ImgViewRepositoryInterface;
use Romchik38\Site2\Application\ImgConverter\View\Size;
use Romchik38\Site2\Application\ImgConverter\View\Type;
use Romchik38\Site2\Application\ImgConverter\View\Width;
use Romchik38\Site2\Domain\Img\VO\Id;
use Romchik38\Site2\Infrastructure\Controllers\Img\ImgData;
use Romchik38\Site2\Infrastructure\Services\ImgConverter\Image;

final class ImgConverterService
{

    public function __construct(
        protected readonly ImgViewRepositoryInterface $imgViewRepository,
        protected readonly string $imgPathPrefix,
        protected readonly ImgConverterInterface $imgConverter
    ) {}

    /** 
     * @throws NoSuchEntityException
     * @throws FileLoaderException
     */
    public function createImg(ImgData $command): string
    {
        // $createCriteria = new CreateCriteria(
        //     Type::fromString($command->type),
        //     AspectRatio::fromString($command->aspectRatio),
        //     Size::fromString($command->size),
        // );

        $img = $this->imgViewRepository->getById(Id::fromString($command->id));
        $imgFullPath = sprintf(
            '%s/%s',
            $this->imgPathPrefix,
            ($img->path())()
        );

        $image = new Image(
            $imgFullPath,
            Width::fromString($command->width),
            Height::fromString($command->height),
            Type::fromString($command->type)
        );

        $this->imgConverter->create($image);

        return '';
    }
}
