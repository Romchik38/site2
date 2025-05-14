<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\Translate\New;

use InvalidArgumentException;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Http\Views\ViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Audio\AdminTranslateCreate\AdminTranslateCreate;
use Romchik38\Site2\Application\Audio\AdminTranslateCreate\CouldNotFindException;
use Romchik38\Site2\Application\Audio\AdminTranslateCreate\Find;
use Romchik38\Site2\Application\Audio\AudioService\CreateTranslate;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\Translate\New\DefaultAction\ViewDto;
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
        private readonly AdminTranslateCreate $adminTranslateCreateService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly Site2SessionInterface $session,
        private readonly CsrfTokenGeneratorInterface $csrfTokenGenerator,
        private readonly LoggerInterface $logger
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $requestData = $request->getQueryParams();
        $command     = Find::fromRequest($requestData);

        $uriRedirectList = $this->urlbuilder->fromArray(['root', 'admin', 'audio']);

        try {
            $translateDto = $this->adminTranslateCreateService->find($command);
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
                $this->translateService->t($e->getMessage())
            );
            return new RedirectResponse($uriRedirectList);
        }

        $csrfToken = $this->csrfTokenGenerator->asBase64();
        $this->session->setData($this->session::ADMIN_CSRF_TOKEN_FIELD, $csrfToken);

        $audioRequirements = $this->adminTranslateCreateService->audioRequirements();

        $pageName = sprintf(
            'Create translate audio id %s language %s',
            $command->id,
            $command->language
        );

        $pageDescription = sprintf(
            'Create translate audio id %s, language %s page',
            $command->id,
            $command->language
        );

        $dto = new ViewDto(
            $pageName,
            $pageDescription,
            $translateDto,
            $this->session::ADMIN_CSRF_TOKEN_FIELD,
            $csrfToken,
            CreateTranslate::AUDIO_ID_FIELD,
            CreateTranslate::LANGUAGE_FIELD,
            CreateTranslate::DESCRIPTION_FIELD,
            CreateTranslate::FILE_FIELD,
            CreateTranslate::FOLDER_FIELD,
            CreateTranslate::ALLOWED_FOLDERS,
            $audioRequirements
        );

        $html = $this->view
            ->setController($this->getController())
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return 'Audio translate create page';
    }
}
