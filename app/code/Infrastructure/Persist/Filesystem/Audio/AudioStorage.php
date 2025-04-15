<?php

declare (strict_types=1);

class AudioStorage
{
    public const TYPE_MP3 = 'mp3';

    /** @throws RuntimeException */
    protected function loadAudioFromFile($filePath): string
    {
        if (! file_exists($filePath) || (! is_readable($filePath))) {
            throw new RuntimeException(sprintf(
                'Audio file %s not exist',
                $filePath
            ));
        }

        $data = file_get_contents($filePath);
        if ($data === false) {
            throw new RuntimeException(sprintf(
                'Error while reading file %s',
                $filePath
            ));
        }
        
        return $data;
    }

    /** @throws RuntimeException */
    protected function getTypeFromString(string $data): string
    {
        if ($this->isMp3($data) === true) {
            return self::TYPE_MP3;
        } else {
            throw new RuntimeException('Audio type is not supported');
        }
    }

    protected function isMp3(string $data): bool
    {
        
    }
}