<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Author\New;

use InvalidArgumentException;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Author\AuthorService\AuthorService;
use Romchik38\Site2\Application\Author\AuthorService\Update;
use Romchik38\Site2\Domain\Author\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\Author\CouldNotSaveException;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use RuntimeException;

use function gettype;
use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    private const string BAD_PROVIDED_DATA_MESSAGE_KEY = 'error.during-check-fix-and-try';
    private const string SUCCESS_UPDATE_KEY            = 'admin.data-success-update';
    private const string COULD_NOT_CHANGE_ACTIVITY_KEY = 'admin.could-not-change-activity';
    private const string COULD_NOT_SAVE_KEY            = 'admin.could-not-save';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly AuthorService $authorService,
        private readonly Site2SessionInterface $session,
        private readonly LoggerInterface $logger
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $requestData = $request->getParsedBody();
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
