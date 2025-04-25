<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Author\New;

use InvalidArgumentException;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LogLevel;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\LoggerServerInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Services\Translate\TranslateInterface;
use Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Application\Author\AuthorService\AuthorService;
use Romchik38\Site2\Application\Author\AuthorService\Update;
use Romchik38\Site2\Domain\Author\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\Author\CouldNotSaveException;
use Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface;
use RuntimeException;

use function gettype;
use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public const string BAD_PROVIDED_DATA_MESSAGE_KEY = 'error.during-check-fix-and-try';
    public const string SUCCESS_UPDATE_KEY            = 'admin.data-success-update';
    public const string COULD_NOT_CHANGE_ACTIVITY_KEY = 'admin.could-not-change-activity';
    public const string COULD_NOT_SAVE_KEY            = 'admin.could-not-save';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly ServerRequestInterface $request,
        private readonly AuthorService $authorService,
        protected readonly Site2SessionInterface $session,
        protected readonly LoggerServerInterface $logger
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(): ResponseInterface
    {
        $requestData = $this->request->getParsedBody();
        if (gettype($requestData) !== 'array') {
            throw new RuntimeException('Incoming data is invalid');
        }

        $uri     = $this->urlbuilder->fromArray(['root', 'admin', 'author']);
        $uriNew  = $this->urlbuilder->fromArray(['root', 'admin', 'author', 'new']);
        $message = '';

        $command = Update::formHash($requestData);

        try {
            $authorId = $this->authorService->update($command);
            $message  = $this->translateService->t($this::SUCCESS_UPDATE_KEY);
            $uri      = $this->urlbuilder->fromArray(
                ['root', 'admin', 'author', $authorId()]
            );
        } catch (InvalidArgumentException $e) {
            $message = sprintf(
                $this->translateService->t($this::BAD_PROVIDED_DATA_MESSAGE_KEY),
                $e->getMessage()
            );
            $uri     = $uriNew;
        } catch (CouldNotChangeActivityException $e) {
            $message = sprintf(
                $this->translateService->t($this::COULD_NOT_CHANGE_ACTIVITY_KEY),
                $e->getMessage()
            );
            $uri     = $uriNew;
        } catch (CouldNotSaveException $e) {
            $message = $this->translateService->t($this::COULD_NOT_SAVE_KEY);
            $uri     = $uriNew;
            $this->logger->log(LogLevel::ERROR, $e->getMessage());
        }

        // Common answer
        if ($message !== '') {
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD,
                $message
            );
        }
        return new RedirectResponse($uri);
    }

    public function getDescription(): string
    {
        return 'Admin Author create new point';
    }
}
