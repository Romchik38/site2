<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Api\ArticleContinueReading;

use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\TextResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Controller\Actions\RequestHandlerTrait;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Views\Dto\Api\ApiDTO;
use Romchik38\Server\Http\Views\Dto\Api\ApiDTOInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Article\ContinueReading\ContinueReading;
use RuntimeException;

use function gettype;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    use RequestHandlerTrait;

    private const API_NAME        = 'Api article continue reading list';
    private const API_DESCRIPTION = 'Api article continue reading list point';
    public const ACCEPTHEADER     = ['application/json'];

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ContinueReading $articleService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Response only with Json
        $responseType = $this->serializeAcceptHeader(
            $this::ACCEPTHEADER,
            $request->getHeaderLine('Accept'),
            'application/json'
        );

        if ($responseType === null) {
            $response = new TextResponse('The requested content type is not acceptable. Excpects application/json.');
            return $response->withStatus(406);
        }

        // Check article id param
        $requestData = $request->getParsedBody();
        if (gettype($requestData) !== 'array') {
            throw new RuntimeException('Incoming data is invalid');
        }

        $list = $this->articleService->list($this->getLanguage());

        return new JsonResponse(new ApiDTO(
            $this::API_NAME,
            $this::API_DESCRIPTION,
            ApiDTOInterface::STATUS_SUCCESS,
            $list
        ));
    }

    public function getDescription(): string
    {
        return $this::API_DESCRIPTION;
    }
}
