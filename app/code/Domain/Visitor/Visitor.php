<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Visitor;

use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\User\VO\Username;
use Romchik38\Site2\Domain\Visitor\VO\CsrfToken;
use Romchik38\Site2\Domain\Visitor\VO\LastVisitedArticles;
use Romchik38\Site2\Domain\Visitor\VO\Message;

final class Visitor
{
    private(set) ?LastVisitedArticles $lastVisitedArticles = null;
    public ?Username $username                             = null;
    private(set) bool $isAcceptedTerms                     = false;
    public ?Message $message                               = null;

    /** @var array<int,ArticleId> $visitedArticles */
    private array $visitedArticles = [];

    public function __construct(
        public CsrfToken $csrfTocken
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

        if ($this->lastVisitedArticles === null) {
            $this->lastVisitedArticles = new LastVisitedArticles($newArticle());
        } else {
            if ($newArticle() !== $this->lastVisitedArticles->first) {
                $this->lastVisitedArticles->second = $this->lastVisitedArticles->first;
                $this->lastVisitedArticles->first  = $newArticle();
            }
        }
    }

    /** @return array<int,ArticleId> */
    public function getVisitedArticles(): array
    {
        return $this->visitedArticles;
    }

    public function checkIsArticleVisited(ArticleId $articleToCheck): bool
    {
        foreach ($this->visitedArticles as $article) {
            if ($article() === $articleToCheck()) {
                return true;
            }
        }
        return false;
    }
}
