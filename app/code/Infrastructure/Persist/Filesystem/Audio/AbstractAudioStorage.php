<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Filesystem\Audio;

use RuntimeException;
use wapmorgan\Mp3Info\Mp3Info;

use function fclose;
use function file_exists;
use function file_get_contents;
use function fopen;
use function fwrite;
use function is_readable;
use function ob_end_clean;
use function ob_get_clean;
use function ob_start;
use function sprintf;
use function strlen;
use function unlink;

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
        ob_start();
        $result = Mp3Info::isValid($data);
        ob_end_clean();
        return $result;
    }

    /**
     * @throws RuntimeException
     */
    protected function saveAudioToFile(string $data, string $fullPath): void
    {
        // 1: Open file
        ob_start();
        $fp = fopen($fullPath, 'w');
        ob_end_clean();
        if ($fp === false) {
            throw new RuntimeException(sprintf(
                'Failed to open file %s to save audio data',
                $fullPath
            ));
        }

        ob_start();
        $result = fwrite($fp, $data);
        ob_end_clean();
        if ($result === false) {
            fclose($fp);
            ob_start();
            $resultUnlink = unlink($fullPath);
            ob_end_clean();
            if ($resultUnlink === true) {
                $message = 'Failed to save audio; Temporary file %s was removed';
            } else {
                $message = 'Failed to save audio; Temporary file %s was not removed';
            }
            throw new RuntimeException(sprintf(
                $message,
                $fullPath
            ));
        }
        fclose($fp);
    }

    /**
     * Removes a file from the file system
     *
     * @throws RuntimeException
     */
    protected function deleteAudioFile(string $fullPath): void
    {
        ob_start();
        $result   = unlink($fullPath);
        $flushVar = ob_get_clean();
        if ($result === false) {
            $message = sprintf('Adio file %s was not deleted', $fullPath);
            if ($flushVar !== false) {
                $message = $flushVar;
            }
            throw new RuntimeException($message);
        }
    }
}
