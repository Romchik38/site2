<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Audio\Translate\Update;

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
use Romchik38\Site2\Application\Audio\AudioService\AudioService;
use Romchik38\Site2\Application\Audio\AudioService\CouldNotUpdateTranslateException;
use Romchik38\Site2\Application\Audio\AudioService\NoSuchAudioException;
use Romchik38\Site2\Application\Audio\AudioService\NoSuchTranslateException;
use Romchik38\Site2\Application\Audio\AudioService\UpdateTranslate;
use RuntimeException;

use function gettype;
use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    private const string BAD_PROVIDED_DATA_MESSAGE_KEY = 'error.during-check-fix-and-try';
    private const string SUCCESS_UPDATE_KEY            = 'admin.data-success-update';
    private const string AUDIO_NOT_EXIST_KEY           = 'admin.audio-with-id-not-exist';
    private const string AUDIO_TRANSLATE_NOT_EXIST     = 'admin.audio-translate-with-language-not-exist';
    private const string COULD_NOT_SAVE_KEY            = 'admin.could-not-save';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly AudioService $audioService,
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
            $this->adminVisitorService->changeMessage($message);
        }
        return new RedirectResponse($uriRedirect);
    }

    public function getDescription(): string
    {
        return 'Admin Audio Translate update point';
    }

    private function createUriWithId(string $id): string
    {
        return $this->urlbuilder->fromArray(
            ['root', 'admin', 'audio', $id]
        );
    }
}
