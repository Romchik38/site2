<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Page\Delete;

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
use Romchik38\Site2\Application\AdminVisitor\AdminVisitorService;
use Romchik38\Site2\Application\Page\PageService\Commands\Delete;
use Romchik38\Site2\Application\Page\PageService\Exceptions\CouldNotDeleteException;
use Romchik38\Site2\Application\Page\PageService\Exceptions\NoSuchPageException;
use Romchik38\Site2\Application\Page\PageService\PageService;
use RuntimeException;

use function gettype;
use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    private const BAD_PROVIDED_DATA_MESSAGE_KEY = 'error.during-check-fix-and-try';
    private const SUCCESS_DELETE_KEY            = 'admin.data-was-deleted-successfully';
    private const COULD_NOT_DELETE_KEY          = 'admin.data-could-not-delete';
    private const PAGE_NOT_EXIST_KEY            = 'admin.page-with-id-not-exist';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly PageService $pageService,
        private readonly AdminVisitorService $adminVisitorService,
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

        $uri     = $this->urlbuilder->fromArray(['root', 'admin', 'page']);
        $message = '';

        $command = Delete::formHash($requestData);

        try {
            $this->pageService->delete($command);
            $message = $this->translateService->t($this::SUCCESS_DELETE_KEY);
        } catch (InvalidArgumentException $e) {
            $message = sprintf(
                $this->translateService->t($this::BAD_PROVIDED_DATA_MESSAGE_KEY),
                $e->getMessage()
            );
        } catch (CouldNotDeleteException $e) {
            $message = $this->translateService->t($this::COULD_NOT_DELETE_KEY);
            $this->logger->log(LogLevel::ERROR, $e->getMessage());
        } catch (NoSuchPageException $e) {
            $message = sprintf($this->translateService->t($this::PAGE_NOT_EXIST_KEY), $command->id);
        }

        // Common answer
        if ($message !== '') {
            $this->adminVisitorService->changeMessage($message);
        }
        return new RedirectResponse($uri);
    }

    public function getDescription(): string
    {
        return 'Admin Page delete point';
    }
}
