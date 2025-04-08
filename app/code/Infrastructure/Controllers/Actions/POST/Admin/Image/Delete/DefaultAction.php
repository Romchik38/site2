<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Image\Delete;

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
use Romchik38\Site2\Application\Image\ImageService\CouldNotDeleteException;
use Romchik38\Site2\Application\Image\ImageService\Delete;
use Romchik38\Site2\Application\Image\ImageService\ImageService;
use Romchik38\Site2\Domain\Image\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\Image\NoSuchImageException;
use Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface;
use RuntimeException;

use function gettype;
use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public const string BAD_PROVIDED_DATA_MESSAGE_KEY = 'error.during-check-fix-and-try';
    public const string SUCCESS_DELETE_KEY            = 'admin.data-was-deleted-successfully';
    public const string COULD_NOT_DELETE_KEY          = 'admin.data-could-not-delete';
    public const string COULD_NOT_CHANGE_ACTIVITY_KEY = 'admin.could-not-change-activity';
    public const string IMAGE_NOT_EXIST_KEY           = 'admin.image-with-id-not-exist';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly ServerRequestInterface $request,
        private readonly ImageService $imageService,
        protected readonly Site2SessionInterface $session,
        protected readonly LoggerServerInterface $logger
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    /** @todo test paths */
    public function execute(): ResponseInterface
    {
        $requestData = $this->request->getParsedBody();
        if (gettype($requestData) !== 'array') {
            throw new RuntimeException('Incoming data is invalid');
        }

        $uri     = $this->urlbuilder->fromArray(['root', 'admin', 'image']);
        $message = '';

        $command = Delete::formHash($requestData);

        try {
            $this->imageService->delete($command);
            $message = $this->translateService->t($this::SUCCESS_DELETE_KEY);
        } catch (InvalidArgumentException $e) {
            $message = sprintf(
                $this->translateService->t($this::BAD_PROVIDED_DATA_MESSAGE_KEY),
                $e->getMessage()
            );
        } catch (NoSuchImageException) {
            $message = sprintf(
                $this->translateService->t($this::IMAGE_NOT_EXIST_KEY),
                $command->id
            );
        } catch (CouldNotChangeActivityException $e) {
            $message = sprintf(
                $this->translateService->t($this::COULD_NOT_CHANGE_ACTIVITY_KEY),
                $e->getMessage()
            );
        } catch (CouldNotDeleteException $e) {
            $message = $this->translateService->t($this::COULD_NOT_DELETE_KEY);
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
        return 'Admin Image delete point';
    }
}
