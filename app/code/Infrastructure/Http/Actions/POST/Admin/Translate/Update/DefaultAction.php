<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Translate\Update;

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
use Romchik38\Site2\Application\Translate\TranslateService\Exceptions\CouldNotSaveException;
use Romchik38\Site2\Application\Translate\TranslateService\Exceptions\NoSuchTranslateException;
use Romchik38\Site2\Application\Translate\TranslateService\TranslateService;
use Romchik38\Site2\Application\Translate\TranslateService\Update;
use RuntimeException;

use function gettype;
use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    private const string BAD_PROVIDED_DATA_MESSAGE_KEY = 'error.during-check-fix-and-try';
    private const string SUCCESS_UPDATE_KEY            = 'admin.data-success-update';
    private const string TRANSLATE_NOT_EXIST_KEY       = 'admin.translate-with-id-not-exist';
    private const string COULD_NOT_SAVE_KEY            = 'admin.could-not-save';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly TranslateService $translateModelService,
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

        $uri     = $this->urlbuilder->fromArray(['root', 'admin', 'translate']);
        $message = '';

        $command = Update::formHash($requestData);

        try {
            $this->translateModelService->update($command);
            $message = $this->translateService->t($this::SUCCESS_UPDATE_KEY);
            $uri     = $this->urlbuilder->fromArray(
                ['root', 'admin', 'translate', $command->id]
            );
        } catch (InvalidArgumentException $e) {
            $message = sprintf(
                $this->translateService->t($this::BAD_PROVIDED_DATA_MESSAGE_KEY),
                $e->getMessage()
            );
        } catch (NoSuchTranslateException) {
            $message = sprintf(
                $this->translateService->t($this::TRANSLATE_NOT_EXIST_KEY),
                $command->id
            );
        } catch (CouldNotSaveException $e) {
            $message = $this->translateService->t($this::COULD_NOT_SAVE_KEY);
            $uri     = $this->urlbuilder->fromArray(
                ['root', 'admin', 'translate', $command->id]
            );
            $this->logger->log(LogLevel::ERROR, $e->getMessage());
        }

        // Common answer
        if ($message !== '') {
            $this->adminVisitorService->changeMessage($message);
        }
        return new RedirectResponse($uri);
    }

    public function getDescription(): string
    {
        return 'Admin Translate update point';
    }
}
