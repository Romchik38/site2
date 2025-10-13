<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\RequestHandlers;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Server\Http\Views\SingleViewInterface;

final class NotFoundHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly SingleViewInterface $view
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $dto  = new DefaultViewDTO(
            '404 Page',
            'Page not found'
        );
        $html = $this->view->setHandlerData($dto)->toString();
        return new HtmlResponse($html, 404);
    }
}
