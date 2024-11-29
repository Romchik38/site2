<?php

declare(strict_types=1);

namespace Romchik38\Server\Services\Streams;

/** Accepts data from function as a resource and converts it to a string */
interface TempStreamInterface
{
    /**
     * @param callable $fn Function to call
     * @param int $resourceIndex indext in param $args to insert resource
     * @param array<int,mixed> $args argements to pass into callback with index for recource
     * @throws \RuntimeException on errors while creating stream
     */
//    public function __invoke(callable $fn, int $resourceIndex, ...$args): string;

    public function write(string $data): void;
}