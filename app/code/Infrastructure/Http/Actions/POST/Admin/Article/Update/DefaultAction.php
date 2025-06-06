<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Article\Update;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use RuntimeException;

use function gettype;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    /** @todo usage */
    private const string BAD_PROVIDED_DATA_MESSAGE_KEY = 'error.during-check-fix-and-try';
    private const string SUCCESS_UPDATE_KEY            = 'admin.data-success-update';
    private const string AUDIO_NOT_EXIST_KEY           = 'admin.audio-with-id-not-exist';
    private const string COULD_NOT_CHANGE_ACTIVITY_KEY = 'admin.could-not-change-activity';
    private const string COULD_NOT_SAVE_KEY            = 'admin.could-not-save';

    /** @todo usage */
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly Site2SessionInterface $session,
        private readonly LoggerInterface $logger
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    /** @todo test all path */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $requestData = $request->getParsedBody();
        if (gettype($requestData) !== 'array') {
            throw new RuntimeException('Incoming data is invalid');
        }

        $uri     = $this->urlbuilder->fromArray(['root', 'admin', 'article']);
        $message = '';

        // $command = Update::formHash($requestData);

        // try {
        //     $this->audioService->update($command);
        //     $message = $this->translateService->t($this::SUCCESS_UPDATE_KEY);
        //     $uri     = $this->createUriWithId($command->id);
        // } catch (InvalidArgumentException $e) {
        //     $message = sprintf(
        //         $this->translateService->t($this::BAD_PROVIDED_DATA_MESSAGE_KEY),
        //         $e->getMessage()
        //     );
        // } catch (NoSuchAudioException) {
        //     $message = sprintf(
        //         $this->translateService->t($this::AUDIO_NOT_EXIST_KEY),
        //         $command->id
        //     );
        // } catch (CouldNotChangeActivityException $e) {
        //     $message = sprintf(
        //         $this->translateService->t($this::COULD_NOT_CHANGE_ACTIVITY_KEY),
        //         $e->getMessage()
        //     );
        //     $uri     = $this->createUriWithId($command->id);
        // } catch (CouldNotUpdateException $e) {
        //     $message = $this->translateService->t($this::COULD_NOT_SAVE_KEY);
        //     $this->logger->log(LogLevel::ERROR, $e->getMessage());
        // }

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
        return 'Admin Article update point';
    }

    /** @todo usage */
    private function createUriWithId(string $id): string
    {
        return $this->urlbuilder->fromArray(
            ['root', 'admin', 'article', $id]
        );
    }
}
