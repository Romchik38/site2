<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImgConverter;

use Romchik38\Site2\Application\ImgConverter\View\AspectRatio;
use Romchik38\Site2\Application\ImgConverter\View\Id;
use Romchik38\Site2\Application\ImgConverter\View\Img;
use Romchik38\Site2\Application\ImgConverter\View\Size;
use Romchik38\Site2\Application\ImgConverter\View\Type;
use Romchik38\Site2\Infrastructure\Controllers\Img\ImgData;

final class ImgConverterService
{
    public function createImg(ImgData $command): Img
    {

        new CreateCriteria(
            Id::fromString($command->id),
            Type::fromString($command->type),
            AspectRatio::fromString($command->aspectRatio),
            Size::fromString($command->size),
        );

        return new Img;
    }
}
