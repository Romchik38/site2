<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ArticleViews;

use InvalidArgumentException;
use Romchik38\Site2\Application\Article\ArticleService\ArticleService;
use Romchik38\Site2\Application\Article\ArticleService\Commands\IncrementViews;
use Romchik38\Site2\Application\Article\ArticleService\Exceptions\CouldNotIncrementViewsException;
use Romchik38\Site2\Application\Article\ArticleService\Exceptions\NoSuchArticleException;
use Romchik38\Site2\Application\Visitor\VisitorService;
use Romchik38\Site2\Application\VisitorServiceException;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;

final class ArticleViewsService
{
    public function __construct(
        private readonly VisitorService $visitorService,
        private readonly ArticleService $articleService
    ) {
    }

    /**
     * @throws CouldNotUpdateViewException
     * @throws InvalidArgumentException
     * @throws NoSuchArticleException
     */
    public function updateView(string $id): void
    {
        try {
            $articleId = new ArticleId($id);
            $visitor   = $this->visitorService->getVisitor();
            if ($visitor->checkIsArticleVisited($articleId)) {
                return;
            }
            $this->visitorService->updateArticleView($articleId);
            $this->articleService->incrementViews(new IncrementViews($id));
        } catch (VisitorServiceException $e) {
            throw new CouldNotUpdateViewException($e->getMessage());
        } catch (CouldNotIncrementViewsException $e) {
            throw new CouldNotUpdateViewException($e->getMessage());
        }
    }
}
