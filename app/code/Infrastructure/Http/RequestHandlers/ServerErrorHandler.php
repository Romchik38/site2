<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\RequestHandlers;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;

use function fclose;
use function file_exists;
use function fopen;
use function fread;
use function sprintf;
use function strlen;
use function trim;

final class ServerErrorHandler implements RequestHandlerInterface
{
    public const DEFAULT_VIEW_NAME_KEY        = 'server-error.header';
    public const DEFAULT_VIEW_DESCRIPTION_KEY = 'server-error.description';

    public function __construct(
        private readonly string $outputFile
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** show static output  */
        try {
            return new HtmlResponse($this->getOutput());
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Error while creating output of server error page: %s',
                $e->getMessage()
            ));
        }
    }

    /**
     * @todo replace with Fileloader
     * @throws RuntimeException - Problem to read the file.
     * @return string content of the server error file
     */
    private function getOutput(): string
    {
        if (file_exists($this->outputFile) === false) {
            throw new RuntimeException(
                sprintf(
                    'Output file not exist %s to show nice server error response',
                    $this->outputFile
                )
            );
        }
        $fp = fopen($this->outputFile, 'r');
        if ($fp === false) {
            throw new RuntimeException(
                sprintf(
                    'Can\'t open to read output file %s to show nice server error response',
                    $this->outputFile
                )
            );
        }
        $file = '';

        $chank = fread($fp, 1024);
        if ($chank === false) {
            fclose($fp);
            throw new RuntimeException(
                sprintf('Cannot read file %s', $this->outputFile)
            );
        }
        while ($chank !== '') {
            $file .= $chank;
            $chank = fread($fp, 1024);
            if ($chank === false) {
                fclose($fp);
                throw new RuntimeException(
                    sprintf('Cannot close file %s', $this->outputFile)
                );
            }
        }

        fclose($fp);
        if (strlen(trim($file)) === 0) {
            throw new RuntimeException(
                sprintf(
                    'Output file is empty %s to show nice server error response',
                    $this->outputFile
                )
            );
        }
        return $file;
    }
}
