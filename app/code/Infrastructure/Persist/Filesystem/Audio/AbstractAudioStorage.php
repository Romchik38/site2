<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Filesystem\Audio;

use RuntimeException;
use wapmorgan\Mp3Info\Mp3Info;

use function file_exists;
use function file_get_contents;
use function is_readable;
use function sprintf;
use function strlen;

abstract class AbstractAudioStorage
{
    public const TYPE_MP3 = 'mp3';

    /** @throws RuntimeException */
    protected function loadAudioFromFile(string $filePath): string
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
    protected function getPropertiesFromFile(string $filename): Audio
    {
        $data = $this->loadAudioFromFile($filename);
        return $this->getPropertiesFromString($data);
    }

    /** @throws RuntimeException */
    protected function getPropertiesFromString(string $data): Audio
    {
        $type = $this->getTypeFromString($data);
        $size = strlen($data);
        return new Audio($type, $size);
    }

    /** @throws RuntimeException - On unsupported type. */
    protected function getTypeFromString(string $data): string
    {
        if ($this->checkMp3($data) === true) {
            return $this::TYPE_MP3;
        }

        throw new RuntimeException('Audio type is not suported by audio storage');
    }

    private function checkMp3(string $data): bool
    {
        return Mp3Info::isValid($data);
    }
}
