<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImgConverter;

use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Application\ImgConverter\View\Height;
use Romchik38\Site2\Application\ImgConverter\View\ImgResult;
use Romchik38\Site2\Application\ImgConverter\View\ImgViewRepositoryInterface;
use Romchik38\Site2\Application\ImgConverter\View\Type;
use Romchik38\Site2\Application\ImgConverter\View\Width;
use Romchik38\Site2\Domain\Img\VO\Id;

final class ImgConverterService
{

    public function __construct(
        protected readonly ImgViewRepositoryInterface $imgViewRepository,
        protected readonly string $imgPathPrefix,
        protected readonly ImgConverterInterface $imgConverter
    ) {}

    /** 
     * @todo check exceptions
     * @throws NoSuchEntityException
     * @throws \RuntimeException
     */
    public function createImg(ImgData $command): ImgResult
    {
        $img = $this->imgViewRepository->getById(Id::fromString($command->id));
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
