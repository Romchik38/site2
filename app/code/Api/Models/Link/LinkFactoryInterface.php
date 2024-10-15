<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\Link;

interface LinkFactoryInterface
{
    public function create(): LinkInterface;
}
