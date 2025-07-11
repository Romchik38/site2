<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Api\ArticleContinueReading;

use InvalidArgumentException;
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
use Romchik38\Site2\Application\Article\ContinueReading\Commands\Check\Check;
use Romchik38\Site2\Application\Article\ContinueReading\Commands\Find\Find;
use Romchik38\Site2\Application\Article\ContinueReading\ContinueReading;
use Romchik38\Site2\Infrastructure\Http\Actions\POST\Api\ArticleContinueReading\DefaultAction\Item;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use RuntimeException;

use function gettype;
use function serialize;
use function unserialize;

/** @todo tests all path */
final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    use RequestHandlerTrait;

    private const API_NAME        = 'Api article continue reading';
    private const API_DESCRIPTION = 'Api article continue reading point';
    private const API_BAD_REQUEST = 'Bad request';
    public const ACCEPTHEADER     = ['application/json'];

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly Site2SessionInterface $session,
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
        $check = Check::formHash($requestData);
        try {
            $checkResult = $this->articleService->check($check);
        } catch (InvalidArgumentException $e) {
            return new JsonResponse(new ApiDTO(
                $this::API_NAME,
                $this::API_DESCRIPTION,
                ApiDTOInterface::STATUS_ERROR,
                $e->getMessage()
            ));
        }
        if (! $checkResult) {
            return new JsonResponse(new ApiDTO(
                $this::API_NAME,
                $this::API_DESCRIPTION,
                ApiDTOInterface::STATUS_ERROR,
                $this::API_BAD_REQUEST
            ));
        }

        $sessionItemData = $this->session->getData(Site2SessionInterface::ARTICLE_LAST_VISITED);
        // No articles visitied before, nothing no responde
        if ($sessionItemData === null || $sessionItemData === '') {
            $this->session->setData(Site2SessionInterface::ARTICLE_LAST_VISITED, serialize(new Item($check->id)));
            return new JsonResponse(new ApiDTO(
                $this::API_NAME,
                $this::API_DESCRIPTION,
                ApiDTOInterface::STATUS_SUCCESS,
                null
            ));
        }
        // Already visit some articles
        $item = unserialize($sessionItemData);
        if (! $item instanceof Item) {
            throw new RuntimeException('Session article data is invalid');
        }

        // Decide what to do
        $articleIdToFind = '';
        if ($item->first === $check->id) {
            if ($item->second === null) {
                return new JsonResponse(new ApiDTO(
                    $this::API_NAME,
                    $this::API_DESCRIPTION,
                    ApiDTOInterface::STATUS_SUCCESS,
                    null
                ));
            } else {
                $articleIdToFind = $item->second;
            }
        } else {
            $articleIdToFind = $item->first;
            $item->first     = $check->id;
            $item->second    = $articleIdToFind;
        }

        $command = new Find($articleIdToFind, $this->getLanguage());
        $article = $this->articleService->find($command);

        $this->session->setData(Site2SessionInterface::ARTICLE_LAST_VISITED, serialize($item));

        return new JsonResponse(new ApiDTO(
            $this::API_NAME,
            $this::API_DESCRIPTION,
            ApiDTOInterface::STATUS_SUCCESS,
            $article
        ));
    }

    public function getDescription(): string
    {
        return $this::API_DESCRIPTION;
    }
}
