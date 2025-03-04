<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Views\Html;

interface CreatePaginationInterface {
    public function create(): string;
}