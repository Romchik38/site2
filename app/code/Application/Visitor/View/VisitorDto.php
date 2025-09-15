<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Visitor\View;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\User\VO\Username;
use Romchik38\Site2\Domain\Visitor\VO\CsrfToken;
use Romchik38\Site2\Domain\Visitor\VO\LastVisitedArticles;
use Romchik38\Site2\Domain\Visitor\VO\Message;

final readonly class VisitorDto
{
    public const USERNAME_FIELD       = 'username';
    public const ACCEPTED_TERMS_FIELD = 'accepted_terms';
    public const CSRF_TOKEN_FIELD     = 'csrf_token';

    /** @var array<int,ArticleId> $visitedArticles */
    public array $visitedArticles;

    /**
     * @throws InvalidArgumentException
     * @param array<int,mixed|ArticleId> $visitedArticles
     * */
    public function __construct(
        public ?Username $username,
        public bool $isAcceptedTerms,
        public CsrfToken $csrfToken,
        public ?Message $message,
        array $visitedArticles,
        public ?LastVisitedArticles $lastVisitedArticles
    ) {
        foreach ($visitedArticles as $article) {
            if (! $article instanceof ArticleId) {
                throw new InvalidArgumentException('param article id is invalid');
            }
        }
        $this->visitedArticles = $visitedArticles;
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

    public function getUserName(): ?string
    {
        if ($this->username === null) {
            return $this->username;
        } else {
            return (string) $this->username;
        }
    }

    public function getCsrfToken(): string
    {
        return (string) $this->csrfToken;
    }

    public function getCsrfTokenField(): string
    {
        return $this::CSRF_TOKEN_FIELD;
    }

    public function getIsAcceptedTerms(): int
    {
        if ($this->isAcceptedTerms) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getMessage(): ?string
    {
        if ($this->message === null) {
            return $this->message;
        } else {
            return (string) $this->message;
        }
    }
}
