<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Visitor;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\User\VO\Username;
use Romchik38\Site2\Domain\Visitor\VO\CsrfToken;
use Romchik38\Site2\Domain\Visitor\VO\Message;

final class Visitor
{
    /** @var array<int,ArticleId> $visitedArticles */
    private array $visitedArticles;

    /**
     * @throws InvalidArgumentException
     * @param array<int,mixed|ArticleId> $visitedArticles
     * */
    public function __construct(
        public CsrfToken $csrfTocken,
        public ?Username $username = null,
        private(set) bool $isAcceptedTerms = false,
        public ?Message $message = null,
        array $visitedArticles = []
    ) {
        /** @todo test */
        foreach ($visitedArticles as $article) {
            if (! $article instanceof ArticleId) {
                throw new InvalidArgumentException('param article is invalid');
            }
        }
        $this->visitedArticles = $visitedArticles;
    }

    public function acceptWithTerms(): void
    {
        $this->isAcceptedTerms = true;
    }

    /** @todo test */
    public function addArticleAsVisited(ArticleId $newArticle): void
    {
        $arr = [$newArticle];
        foreach ($this->visitedArticles as $article) {
            if ($newArticle() === $article()) {
                continue;
            } else {
                $arr[] = $article;
            }
        }
        $this->visitedArticles = $arr;
    }

    /** @return array<int,ArticleId> */
    public function getVisitedArticles(): array
    {
        return $this->visitedArticles;
    }
}
