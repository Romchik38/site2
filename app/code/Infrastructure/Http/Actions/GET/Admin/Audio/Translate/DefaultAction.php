<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\Translate;

use InvalidArgumentException;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Controllers\Errors\ActionNotFoundException;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Application\Audio\AdminTranslateView\AdminTranslateView;
use Romchik38\Site2\Application\Audio\AdminTranslateView\CouldNotFindException;
use Romchik38\Site2\Application\Audio\AdminTranslateView\Find;
use Romchik38\Site2\Application\Audio\AdminTranslateView\NoSuchTranslateException;
use Romchik38\Site2\Application\Audio\AudioService\DeleteTranslate;
use Romchik38\Site2\Application\Audio\AudioService\UpdateTranslate;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\Translate\DefaultAction\ViewDto;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface;

use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public const ERROR_MESSAGE_KEY = 'server-error.message';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly ServerRequestInterface $request,
        private readonly AdminTranslateView $adminTranslateViewService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly Site2SessionInterface $session,
        private readonly CsrfTokenGeneratorInterface $csrfTokenGenerator,
        private readonly LoggerServerInterface $logger,
        private readonly string $audioPathPrefix
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(): ResponseInterface
    {
        $requestData = $this->request->getQueryParams();
        $command     = Find::fromRequest($requestData);

        $uriRedirectList = $this->urlbuilder->fromArray(['root', 'admin', 'audio']);

        try {
            $translateDto = $this->adminTranslateViewService->find($command);
        } catch (CouldNotFindException $e) {
            $this->logger->error($e->getMessage());
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD,
                $this->translateService->t($this::ERROR_MESSAGE_KEY)
            );
            return new RedirectResponse($uriRedirectList);
        } catch (InvalidArgumentException $e) {
            $this->session->setData(
                Site2SessionInterface::MESSAGE_FIELD,
                $this->translateService->t($this::ERROR_MESSAGE_KEY)
            );
            return new RedirectResponse($uriRedirectList);
        } catch (NoSuchTranslateException $e) {
            throw new ActionNotFoundException(sprintf(
                'Audio translate with id %s and language %s not exist',
                $command->id,
                $command->language
            ));
        }

        $csrfToken = $this->csrfTokenGenerator->asBase64();
        $this->session->setData($this->session::ADMIN_CSRF_TOKEN_FIELD, $csrfToken);

        $pageName = sprintf(
            'Audio translate id %s language %s',
            $command->id,
            $command->language
        );

        $pageDescription = sprintf(
            'Audio translate id %s, language %s page (view, edit or delete)',
            $command->id,
            $command->language
        );

        $dto = new ViewDto(
            $pageName,
            $pageDescription,
            $translateDto,
            $this->session::ADMIN_CSRF_TOKEN_FIELD,
            $csrfToken,
            UpdateTranslate::ID_FIELD,
            UpdateTranslate::LANGUAGE_FIELD,
            UpdateTranslate::DESCRIPTION_FIELD,
            $this->audioPathPrefix,
            DeleteTranslate::AUDIO_ID_FIELD,
            DeleteTranslate::LANGUAGE_FIELD
        );

        $html = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return 'Audio translate view page';
    }
}
