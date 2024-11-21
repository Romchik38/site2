<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImgConverter;

use Romchik38\Site2\Application\ImgConverter\View\AspectRatio;
use Romchik38\Site2\Application\ImgConverter\View\ImgViewRepositoryInterface;
use Romchik38\Site2\Application\ImgConverter\View\Size;
use Romchik38\Site2\Application\ImgConverter\View\Type;
use Romchik38\Site2\Domain\Img\VO\Id;
use Romchik38\Site2\Infrastructure\Controllers\Img\ImgData;

final class ImgConverterService
{

    public function __construct(
        protected readonly ImgViewRepositoryInterface $imgViewRepository
    ) {}

    public function createImg(ImgData $command): string
    {
        $createCriteria = new CreateCriteria(
            Type::fromString($command->type),
            AspectRatio::fromString($command->aspectRatio),
            Size::fromString($command->size),
        );

        $img = $this->imgViewRepository->getById(new Id($command->id));

        return '';
    }
}
