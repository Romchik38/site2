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
use Romchik38\Site2\Application\VisitorServiceException;
use RuntimeException;

use function gettype;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public const SERVER_ERROR     = 'server-error.message';
    private const API_NAME        = 'Api username point';
    private const API_DESCRIPTION = 'Information about auth user';
    private const API_ACCEPTED    = 'Accepted';

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
        $requestData = $request->getParsedBody();
        if (gettype($requestData) !== 'array') {
            throw new RuntimeException('Incoming data is invalid');
        }

        try {
            $visitor = $this->visitorService->getVisitor();
        } catch (VisitorServiceException $e) {
            $this->logger->error($e->getMessage());
            return new JsonResponse(new ApiDTO(
                $this::API_NAME,
                $this::API_DESCRIPTION,
                ApiDTOInterface::STATUS_ERROR,
                $this::SERVER_ERROR
            ), 500);
        }

        try {
            $this->visitorService->acceptTerms();
            return new JsonResponse(new ApiDTO(
                $this::API_NAME,
                $this::API_DESCRIPTION,
                ApiDTOInterface::STATUS_SUCCESS,
                $this::API_ACCEPTED
            ));
        } catch (VisitorRepositoryException $e) {
            $this->logger->error($e->getMessage());
            return new JsonResponse(new ApiDTO(
                $this::API_NAME,
                $this::API_DESCRIPTION,
                ApiDTOInterface::STATUS_ERROR,
                $this::SERVER_ERROR
            ), 500);
        }
    }

    public function getDescription(): string
    {
        return 'Api point - Userinfo';
    }
}
