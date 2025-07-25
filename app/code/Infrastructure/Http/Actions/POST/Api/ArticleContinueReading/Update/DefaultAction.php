<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Api\ArticleContinueReading\Update;

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
use Romchik38\Site2\Application\Article\ContinueReading\Commands\Update\Update;
use Romchik38\Site2\Application\Article\ContinueReading\ContinueReading;
use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\CouldNotUpdateException;
use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\NoSuchArticleException;
use RuntimeException;

use function gettype;
use function is_string;
use function sprintf;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    use RequestHandlerTrait;

    private const API_NAME                 = 'Api article continue reading';
    private const API_DESCRIPTION          = 'Api article continue reading point';
    private const API_BAD_REQUEST_TEMPLATE = 'Bad request: %s';
    private const API_ARTICLE_NOT_EXIST    = 'Article does not exist';
    private const API_ACCEPTED             = 'Accepted';
    private const API_SERVER_ERROR         = 'Server error, try later';
    public const ACCEPTHEADER              = ['application/json'];

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

        $id    = '';
        $rawId = $requestData[Update::ID_FIELD] ?? '';
        if (is_string($rawId)) {
            $id = $rawId;
        }

        $command = new Update($id, $this->getLanguage());

        try {
            $this->articleService->update($command);
        } catch (CouldNotUpdateException $e) {
            // log error
            return new JsonResponse(new ApiDTO(
                $this::API_NAME,
                $this::API_DESCRIPTION,
                ApiDTOInterface::STATUS_ERROR,
                $this::API_SERVER_ERROR
            ), 500);
        } catch (InvalidArgumentException $e) {
            return new JsonResponse(new ApiDTO(
                $this::API_NAME,
                $this::API_DESCRIPTION,
                ApiDTOInterface::STATUS_ERROR,
                sprintf($this::API_BAD_REQUEST_TEMPLATE, $e->getMessage())
            ));
        } catch (NoSuchArticleException $e) {
            return new JsonResponse(new ApiDTO(
                $this::API_NAME,
                $this::API_DESCRIPTION,
                ApiDTOInterface::STATUS_ERROR,
                sprintf($this::API_BAD_REQUEST_TEMPLATE, $this::API_ARTICLE_NOT_EXIST)
            ));
        }

        return new JsonResponse(new ApiDTO(
            $this::API_NAME,
            $this::API_DESCRIPTION,
            ApiDTOInterface::STATUS_SUCCESS,
            $this::API_ACCEPTED
        ));
    }

    public function getDescription(): string
    {
        return $this::API_DESCRIPTION;
    }
}
