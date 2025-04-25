<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Audio\Translate\Update;

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
use Romchik38\Site2\Application\Audio\AudioService\AudioService;
use Romchik38\Site2\Application\Audio\AudioService\CouldNotUpdateTranslateException;
use Romchik38\Site2\Application\Audio\AudioService\NoSuchAudioException;
use Romchik38\Site2\Application\Audio\AudioService\NoSuchTranslateException;
use Romchik38\Site2\Application\Audio\AudioService\UpdateTranslate;
use Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface;
use RuntimeException;

use function gettype;
use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public const string BAD_PROVIDED_DATA_MESSAGE_KEY = 'error.during-check-fix-and-try';
    public const string SUCCESS_UPDATE_KEY            = 'admin.data-success-update';
    public const string AUDIO_NOT_EXIST_KEY           = 'admin.audio-with-id-not-exist';
    public const string AUDIO_TRANSLATE_NOT_EXIST     = 'admin.audio-translate-with-language-not-exist';
    public const string COULD_NOT_SAVE_KEY            = 'admin.could-not-save';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly ServerRequestInterface $request,
        private readonly AudioService $audioService,
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

        $uriList     = $this->urlbuilder->fromArray(['root', 'admin', 'audio']);
        $uriRedirect = $uriList;
        $message     = '';

        $command = UpdateTranslate::formHash($requestData);

        try {
            $this->audioService->updateTranslate($command);
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
        } catch (NoSuchAudioException) {
            $message = sprintf(
                $this->translateService->t($this::AUDIO_NOT_EXIST_KEY),
                $command->id
            );
        } catch (NoSuchTranslateException) {
            $message     = sprintf(
                $this->translateService->t($this::AUDIO_TRANSLATE_NOT_EXIST),
                $command->id,
                $command->language
            );
            $uriRedirect = $this->createUriWithId($command->id);
        } catch (CouldNotUpdateTranslateException $e) {
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
        return 'Admin Audio Translate update point';
    }

    protected function createUriWithId(string $id): string
    {
        return $this->urlbuilder->fromArray(
            ['root', 'admin', 'audio', $id]
        );
    }
}
