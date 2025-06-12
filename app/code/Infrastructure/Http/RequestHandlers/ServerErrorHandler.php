<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\RequestHandlers;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Romchik38\Server\Utils\Files\FileLoader;
use Romchik38\Server\Utils\Files\FileLoaderException;
use RuntimeException;

use function sprintf;

final class ServerErrorHandler implements RequestHandlerInterface
{
    private FileLoader $loader;
    public function __construct(
        private readonly string $outputFile
    ) {
        $this->loader = new FileLoader();
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $data = $this->loader->load($this->outputFile);
            return new HtmlResponse($data);
        } catch (FileLoaderException $e) {
            throw new RuntimeException(sprintf(
                'Error while creating output of server error page: %s',
                $e->getMessage()
            ));
        }
    }
}
