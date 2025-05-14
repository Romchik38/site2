<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Audio\Translate\Delete;

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
use Romchik38\Site2\Application\Audio\AudioService\AudioService;
use Romchik38\Site2\Application\Audio\AudioService\CouldNotDeleteTranslateException;
use Romchik38\Site2\Application\Audio\AudioService\DeleteTranslate;
use Romchik38\Site2\Application\Audio\AudioService\NoSuchAudioException;
use Romchik38\Site2\Application\Audio\AudioService\NoSuchTranslateException;
use Romchik38\Site2\Domain\Audio\CouldNotChangeActivityException;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use RuntimeException;

use function gettype;
use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    private const string AUDIO_NOT_EXIST_KEY           = 'admin.audio-with-id-not-exist';
    private const string BAD_PROVIDED_DATA_MESSAGE_KEY = 'error.during-check-fix-and-try';
    private const string SUCCESS_DELETE_KEY            = 'admin.data-was-deleted-successfully';
    private const string COULD_NOT_DELETE_KEY          = 'admin.data-could-not-delete';
    private const string COULD_NOT_CHANGE_ACTIVITY_KEY = 'admin.could-not-change-activity';
    private const string AUDIO_TRANSLATE_NOT_EXIST     = 'admin.audio-translate-with-language-not-exist';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly AudioService $audioService,
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

        $uriRedirect = $this->urlbuilder->fromArray(['root', 'admin', 'audio']);
        $message     = '';

        $command = DeleteTranslate::formHash($requestData);

        try {
            $this->audioService->deleteTranslate($command);
            $message     = $this->translateService->t($this::SUCCESS_DELETE_KEY);
            $uriRedirect = $this->urlbuilder->fromArray(
                ['root', 'admin', 'audio', $command->id]
            );
        } catch (InvalidArgumentException $e) {
            $message = sprintf(
                $this->translateService->t($this::BAD_PROVIDED_DATA_MESSAGE_KEY),
                $e->getMessage()
            );
        } catch (NoSuchTranslateException) {
            $message     = sprintf(
                $this->translateService->t($this::AUDIO_TRANSLATE_NOT_EXIST),
                $command->id,
                $command->language
            );
            $uriRedirect = $this->urlbuilder->fromArray(
                ['root', 'admin', 'audio', $command->id]
            );
        } catch (CouldNotChangeActivityException $e) {
            $message     = sprintf(
                $this->translateService->t($this::COULD_NOT_CHANGE_ACTIVITY_KEY),
                $e->getMessage()
            );
            $uriRedirect = $this->urlbuilder->fromArray(
                ['root', 'admin', 'audio', $command->id]
            );
        } catch (CouldNotDeleteTranslateException $e) {
            $message = $this->translateService->t($this::COULD_NOT_DELETE_KEY);
            $this->logger->log(LogLevel::ERROR, $e->getMessage());
        } catch (NoSuchAudioException $e) {
            $message = sprintf(
                $this->translateService->t($this::AUDIO_NOT_EXIST_KEY),
                $command->id
            );
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
        return 'Admin Audio Translate delete point';
    }
}
