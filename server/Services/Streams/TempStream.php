<?php

declare(strict_types=1);

namespace Romchik38\Server\Services\Streams;

/** @todo update interface */
class TempStream implements TempStreamInterface
{
    /** @var resource $fp */
    protected $fp;
    protected const PROTOCOL = 'php://temp';
    protected const MODE = 'rw';

    public function __construct()
    {
        $fp = fopen($this::PROTOCOL, $this::MODE);
        if ($fp === false) {
            throw new StreamProcessException('Cannot open stream to write data');
        }
        $this->fp = $fp;
    }

    // public function __destruct()
    // {
    //     fclose($this->fp);
    // }

    public function write(string $data): void
    {
        $result = fwrite($this->fp, $data);
        if ($result === false) {
            throw new StreamProcessException('Cannot write data to stream');
        }
    }

    public function writeFromCallable(
        callable $fn,
        int $resourceIndex,
        ...$args
    ): void {
        $args[$resourceIndex] = $this->fp;

        $result = $fn(...$args);

        if ($result === false) {
            throw new StreamProcessException('Error during callable execution');
        }
    }

    public function __invoke(): string
    {
        rewind($this->fp);

        $data = '';
        while (true) {
            $chunk = fgets($this->fp);
            if ($chunk === false) {
                break;
            }
            $data .= $chunk;
        }

        fclose($this->fp);

        return $data;
    }
}
