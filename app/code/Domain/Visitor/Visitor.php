<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Visitor;

use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\User\VO\Username;
use Romchik38\Site2\Domain\Visitor\VO\CsrfToken;
use Romchik38\Site2\Domain\Visitor\VO\Message;

final class Visitor
{
    /** @var array<int,ArticleId> $visitedArticles */
    private array $visitedArticles = [];

    public function __construct(
        public CsrfToken $csrfTocken,
        public ?Username $username = null,
        private(set) bool $isAcceptedTerms = false,
        public ?Message $message = null,
    ) {
    }

    public function acceptWithTerms(): void
    {
        $this->isAcceptedTerms = true;
    }

    public function markArticleAsVisited(ArticleId $newArticle): void
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
