<?php

declare(strict_types=1);

namespace Romchik38\Server\Http\Views;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTOInterface;
use Romchik38\Server\Http\Views\Errors\ViewBuildException;

interface SingleViewInterface
{
    public function setHandlerData(DefaultViewDTOInterface $data): self;

    /**
     * @throws ViewBuildException
     */
    public function toString(): string;
}
