<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Audio\Translate\New;

use InvalidArgumentException;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LogLevel;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Application\Audio\AudioService\AudioService;
use Romchik38\Site2\Application\Audio\AudioService\CouldNotCreateTranslateException;
use Romchik38\Site2\Application\Audio\AudioService\CreateTranslate;
use Romchik38\Site2\Application\Audio\AudioService\UpdateTranslate;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use RuntimeException;

use function array_merge;
use function gettype;
use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    private const string BAD_PROVIDED_DATA_MESSAGE_KEY = 'error.during-check-fix-and-try';
    private const string SUCCESS_UPDATE_KEY            = 'admin.data-success-update';
    private const string COULD_NOT_SAVE_KEY            = 'admin.could-not-save';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly ServerRequestInterface $request,
        private readonly AudioService $audioService,
        private readonly Site2SessionInterface $session,
        private readonly LoggerServerInterface $logger
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(): ResponseInterface
    {
        $requestData = $this->request->getParsedBody();
        if (gettype($requestData) !== 'array') {
            throw new RuntimeException('Incoming data is invalid');
        }

        $uriList     = $this->urlbuilder->fromArray(['root', 'admin', 'audio']);
        $uriRedirect = $uriList;
        $message     = '';

        $files = $this->request->getUploadedFiles();

        $command = CreateTranslate::formHash(array_merge($requestData, $files));

        try {
            $this->audioService->createTranslate($command);
            $message     = $this->translateService->t($this::SUCCESS_UPDATE_KEY);
            $uriRedirect = $this->urlbuilder->fromArray(
                ['root', 'admin', 'audio', 'translate'],
                [
                    UpdateTranslate::ID_FIELD       => $command->id,
                    UpdateTranslate::LANGUAGE_FIELD => $command->language,
                ]
            );
        } catch (InvalidArgumentException $e) {
            $message = sprintf(
                $this->translateService->t($this::BAD_PROVIDED_DATA_MESSAGE_KEY),
                $e->getMessage()
            );
        } catch (CouldNotCreateTranslateException $e) {
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

        return new RedirectResponse($uriRedirect);
    }

    public function getDescription(): string
    {
        return 'Admin Audio Translate new point';
    }
}
