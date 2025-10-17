<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\RequestHandlers;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Server\Http\Views\SingleViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;

final readonly class NotFoundHandler implements RequestHandlerInterface
{
    public function __construct(
        private SingleViewInterface $view,
        private TranslateInterface $translate
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $dto  = new DefaultViewDTO(
            $this->translate->t('404.page_name'),
            $this->translate->t('404.page_description')
        );
        $html = $this->view->setHandlerData($dto)->toString();
        return new HtmlResponse($html, 404);
    }
}
