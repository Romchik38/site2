<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\Register;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public function execute(): ResponseInterface
    {
        $html = <<<HTML
            <h1>Registration page</h1> 
            Please visit <a href="/register/user">Register page</a>
        HTML;
        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return 'Registration page';
    }
}