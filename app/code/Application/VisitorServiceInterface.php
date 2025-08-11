<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application;

interface VisitorServiceInterface
{
    /** @throws VisitorServiceException */
    public function changeMessage(string $message): void;

    /** @throws VisitorServiceException */
    public function clearMessage(): void;

    /** @throws VisitorServiceException */
    public function getVisitor(): mixed;

    /** @throws VisitorServiceException */
    public function logout(): void;
}
