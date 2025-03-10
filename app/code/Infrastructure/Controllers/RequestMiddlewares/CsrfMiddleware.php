<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\RequestMiddlewares;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Api\Controllers\Middleware\RequestMiddlewareInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface;

final class CsrfMiddleware implements RequestMiddlewareInterface
{
    protected const OUTDATED_MESSAGE_KEY = 'middleware.form-data-is-outdated';
    protected const FORM_ERROR_MESSAGE_KEY = 'middleware.form-error';

    public function __construct(
        protected readonly ServerRequestInterface $request,
        protected readonly Site2SessionInterface $session,
        protected readonly UrlbuilderInterface $urlbuilder,
        protected readonly TranslateInterface $translate
    ) {
    }

    public function __invoke(): ?ResponseInterface
    {
        $urlLogin = $this->urlbuilder->fromArray(['root', 'login']);

        $requestData = $this->request->getParsedBody();
        $token = $requestData['csrf_token'] ?? null;

        if ($token === null) {
            $this->session->setData(
                $this->session::MESSAGE_FIELD,
                $this->translate->t($this::FORM_ERROR_MESSAGE_KEY)
            );
            return new RedirectResponse($urlLogin);
        }
       
        $sessionToken = $this->session->getData(Site2SessionInterface::CSRF_TOKEN_FIELD);
        if ($sessionToken === '' || $token === '') {
            $this->session->setData(
                $this->session::MESSAGE_FIELD,
                $this->translate->t($this::FORM_ERROR_MESSAGE_KEY)
            );
            return new RedirectResponse($urlLogin);
        }

        if ($sessionToken !== $token) {
            $this->session->setData(
                $this->session::MESSAGE_FIELD,
                $this->translate->t($this::OUTDATED_MESSAGE_KEY)
            );
            return new RedirectResponse($urlLogin);
        }

        // ? set token to ''

        return null;
    }
}