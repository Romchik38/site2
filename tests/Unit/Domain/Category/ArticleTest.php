<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Category;

use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Article\VO\ArticleId;
use Romchik38\Site2\Domain\Category\Entities\Article;

final class ArticleTest extends TestCase
{
    public function testProperties(): void
    {
        $articleId = new ArticleId('some-id');
        $article   = new Article($articleId, true);

        $this->assertSame($articleId, $article->id);
        $this->assertSame(true, $article->active);
    }
}
