<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Article\Entities;

use DateTime;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Article\Article;
use Romchik38\Site2\Domain\Article\Entities\Author;
use Romchik38\Site2\Domain\Article\Entities\Translate;
use Romchik38\Site2\Domain\Article\VO\Description;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Article\VO\Name;
use Romchik38\Site2\Domain\Article\VO\ShortDescription;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class ArticleTest extends TestCase
{
    public function testCreate(): void
    {
        $id        = new ArticleId('some-id');
        $author    = new Author(new AuthorId('1'), true);
        $languages = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];

        $article = Article::create(
            $id,
            $author,
            $languages
        );

        $this->assertSame($id, $article->id);
        $this->assertSame(false, $article->active);
        $this->assertSame($author, $article->author);
        $this->assertSame(null, $article->audio);
        $this->assertSame(null, $article->image);
        $this->assertSame([], $article->getCategories());
        $this->assertSame([], $article->getTranslates());
    }

    public function testCreateWithTranslates(): void
    {
        $id        = new ArticleId('some-id');
        $author    = new Author(new AuthorId('1'), true);
        $languages = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];

        $article = Article::create(
            $id,
            $author,
            $languages
        );

        $translates = [
            new Translate(
                new LanguageId('en'),
                new Name('some name'),
                new ShortDescription('Some article short description'),
                new Description('Some article description'),
                new DateTime(),
                new DateTime()
            ),
        ];

        $article = Article::create(
            $id,
            $author,
            $languages,
            null,
            null,
            [],
            $translates
        );

        $this->assertSame($translates, $article->getTranslates());
    }


}
