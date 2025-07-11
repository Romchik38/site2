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
use Romchik38\Site2\Application\Article\ContinueReading\Commands\Find\Find;
use Romchik38\Site2\Application\Article\ContinueReading\ContinueReading;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use RuntimeException;

use function count;
use function gettype;
use function is_array;
use function is_string;
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
        $articleId = $requestData[Find::ID_FIELD] ?? null;
        // id not presend or invalid - bad request
        if (! is_string($articleId)) {
            return new JsonResponse(new ApiDTO(
                $this::API_NAME,
                $this::API_DESCRIPTION,
                ApiDTOInterface::STATUS_ERROR,
                $this::API_BAD_REQUEST
            ));
        }

        $articles = $this->session->getData(Site2SessionInterface::ARTICLE_LAST_VISITED);
        // No articles visitied before, nothing no responde
        if ($articles === null || $articles === '') {
            return new JsonResponse(new ApiDTO(
                $this::API_NAME,
                $this::API_DESCRIPTION,
                ApiDTOInterface::STATUS_SUCCESS,
                null
            ));
        }
        // Already visit some articles
        $items = unserialize($articles);
        if (! is_array($items)) {
            throw new RuntimeException('Session article data is invalid');
        }
        $itemCount = count($items);
        if ($itemCount === 0) {
            throw new RuntimeException('Session article data is invalid - 0 artiles');
            // Only one visited, nothing to responde
        } elseif ($itemCount === 1) {
            return new JsonResponse(new ApiDTO(
                $this::API_NAME,
                $this::API_DESCRIPTION,
                ApiDTOInterface::STATUS_SUCCESS,
                null
            ));
        }
        // Articles found
        $articleIdToFind = '';
        foreach ($items as $item) {
            if (! is_string($item)) {
                throw new RuntimeException('Session article data is invalid - id not a string');
            }
            if ($articleId === $item) {
                continue;
            } else {
                $articleIdToFind = $item;
            }
        }

        $command = new Find($articleIdToFind, $this->getLanguage());
        $article = $this->articleService->find($command);

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
