<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Author\Update;

use InvalidArgumentException;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Application\Author\AuthorService\AuthorService;
use RuntimeException;
use Romchik38\Site2\Application\Author\AuthorService\Update;
use Romchik38\Site2\Domain\Author\NoSuchAuthorException;
use Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface;

final class DefaultAction extends AbstractMultiLanguageAction
    implements DefaultActionInterface
{
    public const string BAD_PROVIDED_DATA_MESSAGE_KEY = 'error.during-check-fix-and-try';
    public const string SUCCESS_UPDATE_KEY            = 'admin.data-success-update';
    public const string AUTHOR_NOT_EXIST_KEY          = 'admin.author-with-id-not-exist';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly ServerRequestInterface $request,
        private readonly AuthorService $authorService,
        protected readonly Site2SessionInterface $session,

    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(): ResponseInterface
    {
        /** @todo  csrf */

        $requestData = $this->request->getParsedBody();
        if (gettype($requestData) !== 'array') {
            throw new RuntimeException('Incoming data is invalid');
        }

        $uri = $this->urlbuilder->fromArray(['root', 'admin', 'author']);
        $message = '';

        $command = Update::formHash($requestData);
        $uriId = $this->urlbuilder->fromArray(
            ['root', 'admin', 'author', $command->id]
        );
        try {
            $this->authorService->update($command);
            $message = $this::SUCCESS_UPDATE_KEY;
            $uri = $uriId;
        } catch(InvalidArgumentException $e) {
            $message = sprintf(
                $this->translateService->t($this::BAD_PROVIDED_DATA_MESSAGE_KEY),
                $e->getMessage()
            );
            $uri = $uriId;
        } catch(NoSuchAuthorException) {
            $message = $this::AUTHOR_NOT_EXIST_KEY;
        }

        // Common answer
        $this->session->setData(
            Site2SessionInterface::MESSAGE_FIELD,
            $message
        );
        return new RedirectResponse($uri);
    }

    public function getDescription(): string
    {
        return 'Admin Author update point';
    }
}