<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Category\Update;

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
use Romchik38\Site2\Application\Category\CategoryService\CategoryService;
use Romchik38\Site2\Application\Category\CategoryService\Commands\Update;
use Romchik38\Site2\Application\Category\CategoryService\Exceptions\CouldNotUpdateException;
use Romchik38\Site2\Application\Category\CategoryService\Exceptions\NoSuchCategoryException;
use Romchik38\Site2\Domain\Category\CouldNotChangeActivityException;
use Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface;
use RuntimeException;

use function gettype;
use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public const string BAD_PROVIDED_DATA_MESSAGE_KEY = 'error.during-check-fix-and-try';
    public const string SUCCESS_UPDATE_KEY            = 'admin.data-success-update';
    public const string CATEGORY_NOT_EXIST_KEY        = 'admin.category-with-id-not-exist';
    public const string COULD_NOT_CHANGE_ACTIVITY_KEY = 'admin.could-not-change-activity';
    public const string COULD_NOT_SAVE_KEY            = 'admin.could-not-save';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly ServerRequestInterface $request,
        private readonly CategoryService $categoryService,
        protected readonly Site2SessionInterface $session,
        protected readonly LoggerServerInterface $logger
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    /**
     * @todo csrf
     * @todo test all paths
     * */
    public function execute(): ResponseInterface
    {
        $requestData = $this->request->getParsedBody();
        if (gettype($requestData) !== 'array') {
            throw new RuntimeException('Incoming data is invalid');
        }

        $uri     = $this->urlbuilder->fromArray(['root', 'admin', 'category']);
        $message = '';

        $command = Update::formHash($requestData);

        try {
            $this->categoryService->update($command);
            $message = $this->translateService->t($this::SUCCESS_UPDATE_KEY);
            $uri     = $this->createUriWithId($command->id);
        } catch (InvalidArgumentException $e) {
            $message = sprintf(
                $this->translateService->t($this::BAD_PROVIDED_DATA_MESSAGE_KEY),
                $e->getMessage()
            );
        } catch (NoSuchCategoryException) {
            $message = sprintf(
                $this->translateService->t($this::CATEGORY_NOT_EXIST_KEY),
                $command->id
            );
        } catch (CouldNotChangeActivityException $e) {
            $message = sprintf(
                $this->translateService->t($this::COULD_NOT_CHANGE_ACTIVITY_KEY),
                $e->getMessage()
            );
            $uri     = $this->createUriWithId($command->id);
        } catch (CouldNotUpdateException $e) {
            $message = $this->translateService->t($this::COULD_NOT_SAVE_KEY);
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
        return 'Admin Category update point';
    }

    protected function createUriWithId(string $id): string
    {
        return $this->urlbuilder->fromArray(
            ['root', 'admin', 'category', $id]
        );
    }
}
