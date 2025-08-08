<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\RequestMiddlewares;

use InvalidArgumentException;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Middleware\RequestMiddlewareInterface;
use Romchik38\Server\Http\Controller\Path;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Visitor\VisitorService;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use RuntimeException;

use function gettype;

final class CsrfMiddleware implements RequestMiddlewareInterface
{
    private const FORM_ERROR_MESSAGE_KEY = 'middleware.form-error';

    public function __construct(
        private readonly Site2SessionInterface $session,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly TranslateInterface $translate,
        private readonly Path $redirectPath,
        private readonly string $tokenFieldName,
        private readonly VisitorService $visitorService
    ) {
        if ($tokenFieldName === '') {
            throw new InvalidArgumentException('csrf tocken field is empty');
        }
    }

    public function __invoke(ServerRequestInterface $request): ?ResponseInterface
    {
        $urlLogin = $this->urlbuilder->fromPath($this->redirectPath);

        $requestData = $request->getParsedBody();
        if (gettype($requestData) !== 'array') {
            throw new RuntimeException('Incoming data is invalid');
        }

        $visitor = $this->visitorService->getVisitor();
        $csrfToken = $requestData[$visitor::CSRF_TOKEN_FIELD] ?? null;

        if ($csrfToken !== $visitor->getCsrfToken()) {
            $this->session->setData(
                $this->session::MESSAGE_FIELD,
                $this->translate->t($this::FORM_ERROR_MESSAGE_KEY)
            );
            return new RedirectResponse($urlLogin);
        }

        return null;
    }
}
