<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Api\ArticleViews;

use InvalidArgumentException;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Views\Dto\Api\ApiDTO;
use Romchik38\Server\Http\Views\Dto\Api\ApiDTOInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Article\ArticleService\ArticleService;
use Romchik38\Site2\Application\Article\ArticleService\Commands\IncrementViews;
use Romchik38\Site2\Application\Article\ArticleService\Exceptions\NoSuchArticleException;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use RuntimeException;

use function array_find;
use function array_push;
use function gettype;
use function serialize;
use function unserialize;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    private const API_NAME            = 'Api article views point';
    private const API_DESCRIPTION     = 'Update article views count';
    private const API_ACCEPTED        = 'Accepted';
    private const API_BAD_REQUEST     = 'Bad request';
    private const API_NO_SUCH_ARTICLE = 'No such article';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        private readonly Site2SessionInterface $session,
        private readonly ArticleService $articleService
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    /** @todo accept only json */
    /** @todo tests all path */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Check article id param
        $requestData = $request->getParsedBody();
        if (gettype($requestData) !== 'array') {
            throw new RuntimeException('Incoming data is invalid');
        }
        $command = IncrementViews::formHash($requestData);
        if ($command->id === '') {
            return new JsonResponse(new ApiDTO(
                $this::API_NAME,
                $this::API_DESCRIPTION,
                ApiDTOInterface::STATUS_ERROR,
                $this::API_BAD_REQUEST
            ));
        }

        $articles   = $this->session->getData(Site2SessionInterface::ARTICLE_VIEWS_FIELD);
        $updateFlag = false;
        $items      = [];
        // 1 No articles visitied
        if ($articles === null || $articles === '') {
            $updateFlag = true;
        // 2 Visit articles
        } else {
            $items = unserialize($articles);
            if (gettype($items) !== 'array') {
                throw new RuntimeException('Session article data is invalid');
            }
            $found = array_find($items, fn(string $value) => $command->id === $value);
            if ($found === null) {
                $updateFlag = true;
            }
        }

        if ($updateFlag) {
            try {
                $this->articleService->incrementViews($command);
                array_push($items, $command->id);
                $this->session->setData(Site2SessionInterface::ARTICLE_VIEWS_FIELD, serialize($items));
            } catch (NoSuchArticleException) {
                return new JsonResponse(new ApiDTO(
                    $this::API_NAME,
                    $this::API_DESCRIPTION,
                    ApiDTOInterface::STATUS_ERROR,
                    $this::API_NO_SUCH_ARTICLE
                ));
            } catch (InvalidArgumentException $e) {
                return new JsonResponse(new ApiDTO(
                    $this::API_NAME,
                    $this::API_DESCRIPTION,
                    ApiDTOInterface::STATUS_ERROR,
                    $e->getMessage()
                ));
            }
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
