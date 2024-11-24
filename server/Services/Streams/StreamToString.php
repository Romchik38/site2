<?php

declare(strict_types=1);

namespace Romchik38\Server\Services\Streams;

use Romchik38\Server\Api\Services\StreamToStringInterface;

class StreamToString implements StreamToStringInterface
{
    public function __construct(
        protected readonly string $protocol = 'php://temp',
        protected readonly string $mode = 'rw'
    ) {}

    public function __invoke(
        callable $fn,
        int $resourceIndex,
        ...$args
    ): string {
        $fp = fopen($this->protocol, $this->mode);
        if ($fp === false) {
            throw new \RuntimeException('Cannot open stream to write data');
        }
        $args[$resourceIndex] = $fp;

        $result = $fn(...$args);

        if ($result === false) {
            throw new \RuntimeException('Error during callback execution');
        }

        rewind($fp);

        $data = '';
        while (true) {
            $chunk = fgets($fp);
            if ($chunk === false) {
                break;
            }
            $data .= $chunk;
        }

        fclose($fp);

        return $data;
    }
}
