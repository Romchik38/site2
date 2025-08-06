<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Api\Userinfo;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Views\Dto\Api\ApiDTO;
use Romchik38\Server\Http\Views\Dto\Api\ApiDTOInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Visitor\RepositoryException as VisitorRepositoryException;
use Romchik38\Site2\Application\Visitor\VisitorService;
use Romchik38\Site2\Application\Visitor\View\VisitorDto;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public const SERVER_ERROR             = 'server-error.message';
    private const MUST_BE_LOGGED_IN_ERROR = 'You must be logged in to make a request';
    private const API_NAME                = 'Api username point';
    private const API_DESCRIPTION         = 'Information about auth user';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly VisitorService $visitorService,
        private readonly LoggerInterface $logger
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $visitor = $this->visitorService->getVisitor();
        } catch (VisitorRepositoryException $e) {
            $this->logger->error($e->getMessage());
            return new JsonResponse(new ApiDTO(
                $this::API_NAME,
                $this::API_DESCRIPTION,
                ApiDTOInterface::STATUS_ERROR,
                $this::SERVER_ERROR
            ), 500);
        }

        $dto = new ApiDTO(
            $this::API_NAME,
            $this::API_DESCRIPTION,
            ApiDTOInterface::STATUS_SUCCESS,
            [
                VisitorDto::USERNAME_FIELD => $visitor->username,
                VisitorDto::ACCEPTED_TERMS_FIELD => $visitor->isAcceptedTerms
            ]
        );

        return new JsonResponse($dto);
    }

    public function getDescription(): string
    {
        return 'Api point - Userinfo';
    }
}
