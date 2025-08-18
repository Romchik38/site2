<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Api\ArticleViews;

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
use Romchik38\Site2\Application\Article\ArticleService\Exceptions\NoSuchArticleException;
use Romchik38\Site2\Application\Article\ArticleViews\ArticleViewsService;
use Romchik38\Site2\Application\Article\ArticleViews\CouldNotUpdateViewException;
use Romchik38\Site2\Application\Article\ArticleViews\UpdateView;
use RuntimeException;

use function gettype;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    use RequestHandlerTrait;

    public const ACCEPTHEADER         = ['application/json'];
    private const API_NAME            = 'Api article views point';
    private const API_DESCRIPTION     = 'Update article views count';
    private const API_ACCEPTED        = 'Accepted';
    private const API_NO_SUCH_ARTICLE = 'No such article';
    public const API_SERVER_ERROR     = 'Server error, please try later';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly ArticleViewsService $articleViewsService
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
        $command = UpdateView::formHash($requestData);

        try {
            $this->articleViewsService->updateView($command);
        } catch (InvalidArgumentException $e) {
            return new JsonResponse(new ApiDTO(
                $this::API_NAME,
                $this::API_DESCRIPTION,
                ApiDTOInterface::STATUS_ERROR,
                $e->getMessage()
            ));
        } catch (NoSuchArticleException) {
            return new JsonResponse(new ApiDTO(
                $this::API_NAME,
                $this::API_DESCRIPTION,
                ApiDTOInterface::STATUS_ERROR,
                $this::API_NO_SUCH_ARTICLE
            ));
        } catch (CouldNotUpdateViewException $e) {
            return new JsonResponse(new ApiDTO(
                $this::API_NAME,
                $this::API_DESCRIPTION,
                ApiDTOInterface::STATUS_ERROR,
                $this::API_SERVER_ERROR
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
