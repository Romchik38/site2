<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminView;

use Romchik38\Site2\Application\Image\AdminView\View\Dto;
use Romchik38\Site2\Application\Image\AdminView\View\MetadataDto;

final class Result
{
    public function __construct(
        public readonly Dto $image,
        public readonly MetadataDto $metadata
    ) {   
    }
}