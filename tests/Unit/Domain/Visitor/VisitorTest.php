<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Visitor;

use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\User\VO\Username;
use Romchik38\Site2\Domain\Visitor\Visitor;
use Romchik38\Site2\Domain\Visitor\VO\CsrfToken;
use Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface;
use Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorUseRandomBytes;
use RuntimeException;

use function count;

final class VisitorTest extends TestCase
{
    public readonly CsrfTokenGeneratorInterface $csrfTokenGenerator;

    public function setUp(): void
    {
        $this->csrfTokenGenerator = new CsrfTokenGeneratorUseRandomBytes(32);
    }

    public function testConstructDefaultNull(): void
    {
        $token = new CsrfToken($this->csrfTokenGenerator->asBase64());
        $model = new Visitor($token);
        $this->assertSame(null, $model->username);
        $this->assertSame(null, $model->message);
    }

    /**
     * Also tested:
     *   - getVisitedArticles
     */
    public function testMarkArticleAsVisited(): void
    {
        $token          = new CsrfToken($this->csrfTokenGenerator->asBase64());
        $visitedArticle = new ArticleId('some-article');

        $model = new Visitor($token);
        $model->markArticleAsVisited($visitedArticle);
        $this->assertSame([$visitedArticle], $model->getVisitedArticles());
    }

    public function testMarkArticleAsVisitedTwice(): void
    {
        $token           = new CsrfToken($this->csrfTokenGenerator->asBase64());
        $visitedArticle1 = new ArticleId('some-article1');
        $visitedArticle2 = new ArticleId('some-article2');

        $model = new Visitor($token);
        $model->markArticleAsVisited($visitedArticle1);
        $model->markArticleAsVisited($visitedArticle2);
        $model->markArticleAsVisited($visitedArticle1);  // The attempt is not counted.

        $visitedArticles = $model->getVisitedArticles();
        $this->assertSame(2, count($visitedArticles));
        foreach ($visitedArticles as $article) {
            if (
                $article() !== $visitedArticle1() &&
                $article() !== $visitedArticle2()
            ) {
                throw new RuntimeException(
                    'test testMarkArticleAsVisitedTwice failed - it has non expected artilce id'
                );
            }
        }
    }

    public function testAcceptWithTerms(): void
    {
        $username = new Username('user_1');
        $token    = new CsrfToken($this->csrfTokenGenerator->asBase64());
        $model    = new Visitor($token, $username);

        $this->assertSame(false, $model->isAcceptedTerms);
        $model->acceptWithTerms();
        $this->assertSame(true, $model->isAcceptedTerms);
    }

    public function testCheckIsArticleVisited(): void
    {
        $token           = new CsrfToken($this->csrfTokenGenerator->asBase64());
        $model           = new Visitor($token);
        $visitedArticle1 = new ArticleId('some-article1');
        $visitedArticle2 = new ArticleId('some-article2');

        $model->markArticleAsVisited($visitedArticle1);

        $this->assertSame(true, $model->checkIsArticleVisited($visitedArticle1));
        $this->assertSame(false, $model->checkIsArticleVisited($visitedArticle2));
    }

    public function testLastVisited(): void
    {
        $token = new CsrfToken($this->csrfTokenGenerator->asBase64());
        $model = new Visitor($token);

        $a1 = new ArticleId('some-article1');
        $a2 = new ArticleId('some-article2');
        $a3 = new ArticleId('some-article3');

        $this->assertSame(null, $model->lastVisitedArticles);
        $model->markArticleAsVisited($a1);
        $this->assertSame('some-article1', $model->lastVisitedArticles->first);
        $model->markArticleAsVisited($a1);
        $this->assertSame('some-article1', $model->lastVisitedArticles->first);
        $this->assertSame(null, $model->lastVisitedArticles->second);
        $model->markArticleAsVisited($a2);
        $this->assertSame('some-article2', $model->lastVisitedArticles->first);
        $this->assertSame('some-article1', $model->lastVisitedArticles->second);
        $model->markArticleAsVisited($a3);
        $this->assertSame('some-article3', $model->lastVisitedArticles->first);
        $this->assertSame('some-article2', $model->lastVisitedArticles->second);
    }
}
