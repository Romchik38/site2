<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\SessionInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractAction;
use Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\DefaultAction\ViewDTO;

final class DefaultAction extends AbstractAction implements DefaultActionInterface
{
    public function __construct(
        protected readonly ViewInterface $view,
        protected readonly SessionInterface $session
    ) {
    }

    public function execute(): ResponseInterface
    {
        $message = (string) $this->session->getData('message');
        if ($message !== '') {
            $this->session->setData('message', '');
        }
        $dto = new ViewDTO('Admin', 'Admin page', $message);
        $html = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();
        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return 'Admin panel';
    }
}