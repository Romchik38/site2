<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application;

interface VisitorServiceInterface
{
    public function changeMessage(string $message): void;

    public function getVisitor(): mixed;

    public function logout(): void;
}
