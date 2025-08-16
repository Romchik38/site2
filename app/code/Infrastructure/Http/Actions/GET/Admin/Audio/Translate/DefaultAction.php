<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\Translate;

use InvalidArgumentException;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Controller\Errors\ActionNotFoundException;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Http\Views\ControllerViewInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\AdminVisitor\AdminVisitorService;
use Romchik38\Site2\Application\Audio\AdminTranslateView\AdminTranslateView;
use Romchik38\Site2\Application\Audio\AdminTranslateView\CouldNotFindException;
use Romchik38\Site2\Application\Audio\AdminTranslateView\Find;
use Romchik38\Site2\Application\Audio\AdminTranslateView\NoSuchTranslateException;
use Romchik38\Site2\Application\Audio\AudioService\DeleteTranslate;
use Romchik38\Site2\Application\Audio\AudioService\UpdateTranslate;
use Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\Translate\DefaultAction\ViewDto;

use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public const ERROR_MESSAGE_KEY = 'server-error.message';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ControllerViewInterface $view,
        private readonly AdminTranslateView $adminTranslateViewService,
        private readonly UrlbuilderInterface $urlbuilder,
        private readonly LoggerInterface $logger,
        private readonly string $audioPathPrefix,
        private readonly AdminVisitorService $adminVisitorService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $requestData        = $request->getQueryParams();
        $command            = Find::fromRequest($requestData);
        $uriRedirectList    = $this->urlbuilder->fromArray(['root', 'admin', 'audio']);
        $serverErrorMessage = $this->translateService->t($this::ERROR_MESSAGE_KEY);

        try {
            $translateDto = $this->adminTranslateViewService->find($command);
        } catch (CouldNotFindException $e) {
            $this->logger->error($e->getMessage());
            $this->adminVisitorService->changeMessage($serverErrorMessage);
            return new RedirectResponse($uriRedirectList);
        } catch (InvalidArgumentException $e) {
            $this->adminVisitorService->changeMessage($serverErrorMessage);
            return new RedirectResponse($uriRedirectList);
        } catch (NoSuchTranslateException $e) {
            throw new ActionNotFoundException(sprintf(
                'Audio translate with id %s and language %s not exist',
                $command->id,
                $command->language
            ));
        }

        $visitor = $this->adminVisitorService->getVisitor();

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
            $visitor->getCsrfTokenField(),
            $visitor->getCsrfToken(),
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
