<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Author;

use InvalidArgumentException;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DynamicActionInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Controllers\Errors\ActionNotFoundException;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Site2\Application\Author\AdminView\AdminViewService;
use Romchik38\Site2\Domain\Author\NoSuchAuthorException;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Author\DynamicAction\ViewDto;

use function sprintf;

final class DynamicAction extends AbstractMultiLanguageAction
    implements DynamicActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ViewInterface $view,
        private readonly AdminViewService $adminViewService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(string $dynamicRoute): ResponseInterface
    {
        try {
            $authorId = new AuthorId($dynamicRoute);
        } catch(InvalidArgumentException $e) {
            throw new ActionNotFoundException($e->getMessage());
        }

        try {
            $authorDto = $this->adminViewService->find($authorId);
        } catch(NoSuchAuthorException) {
            throw new ActionNotFoundException(sprintf(
                'Author with id %s not exist',
                $authorId()
            ));
        }

        $dto = new ViewDto(
            sprintf('Author view id %s', $authorId()),
            sprintf('Authors view page with id %s', $authorId()),
            $authorDto
        );

        $html = $this->view
            ->setController($this->getController(), $dynamicRoute)
            ->setControllerData($dto)
            ->toString();

        return new HtmlResponse($html);
        
        
    }

    public function getDescription(string $dynamicRoute): string
    {
        return 'Admin Author page view ' . $dynamicRoute;
    }

    public function getDynamicRoutes(): array
    {
        return [];
    }
}