<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Article\Entities;

use DateTime;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Article\Article;
use Romchik38\Site2\Domain\Article\Entities\Audio;
use Romchik38\Site2\Domain\Article\Entities\Author;
use Romchik38\Site2\Domain\Article\Entities\Category;
use Romchik38\Site2\Domain\Article\Entities\Image;
use Romchik38\Site2\Domain\Article\Entities\Translate;
use Romchik38\Site2\Domain\Article\VO\Description;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Article\VO\Name;
use Romchik38\Site2\Domain\Article\VO\ShortDescription;
use Romchik38\Site2\Domain\Audio\VO\Id as AudioId;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Category\VO\Identifier as CategoryId;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;
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

    public function testCreateWithImage(): void
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

        $image = new Image(new ImageId(1), true);

        $article = Article::create(
            $id,
            $author,
            $languages,
            null,
            $image
        );

        $this->assertSame($image, $article->image);
    }

    public function testCreateWithAudio(): void
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

        $audio = new Audio(new AudioId(1), true);

        $article = Article::create(
            $id,
            $author,
            $languages,
            $audio
        );

        $this->assertSame($audio, $article->audio);
    }

    public function testConstructValidArticle(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), true);
        $image  = new Image(new ImageId(1), true);

        $categories = [
            new Category(
                new CategoryId('cat-1'),
                true,
                1
            ),
        ];

        $languages = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];

        $translates = [
            new Translate(
                new LanguageId('en'),
                new Name('some name'),
                new ShortDescription('Some article short description'),
                new Description('Some article description'),
                new DateTime(),
                new DateTime()
            ),
            new Translate(
                new LanguageId('uk'),
                new Name('Стаття про щось'),
                new ShortDescription('Короткий опис статті про щось'),
                new Description('Повний опис статті про щось'),
                new DateTime(),
                new DateTime()
            ),
        ];

        $article = new Article(
            $id,
            true,
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );

        $this->assertSame($id, $article->id);
        $this->assertSame(true, $article->active);
        $this->assertSame($audio, $article->audio);
        $this->assertSame($author, $article->author);
        $this->assertSame($image, $article->image);
        $this->assertSame($categories, $article->getCategories());
        $this->assertSame($translates, $article->getTranslates());
    }

        public function testConstructThrowsErrorInvalidImageNotActive(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), true);
        $image  = new Image(new ImageId(1), false);

        $categories = [
            new Category(
                new CategoryId('cat-1'),
                true,
                1
            ),
        ];

        $languages = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];

        $translates = [
            new Translate(
                new LanguageId('en'),
                new Name('some name'),
                new ShortDescription('Some article short description'),
                new Description('Some article description'),
                new DateTime(),
                new DateTime()
            ),
            new Translate(
                new LanguageId('uk'),
                new Name('Стаття про щось'),
                new ShortDescription('Короткий опис статті про щось'),
                new Description('Повний опис статті про щось'),
                new DateTime(),
                new DateTime()
            ),
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param article image is not active');
        
        new Article(
            $id,
            true,
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );
    }

    public function testConstructThrowsErrorInvalidImageNull(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), true);
        $image  = null;

        $categories = [
            new Category(
                new CategoryId('cat-1'),
                true,
                1
            ),
        ];

        $languages = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];

        $translates = [
            new Translate(
                new LanguageId('en'),
                new Name('some name'),
                new ShortDescription('Some article short description'),
                new Description('Some article description'),
                new DateTime(),
                new DateTime()
            ),
            new Translate(
                new LanguageId('uk'),
                new Name('Стаття про щось'),
                new ShortDescription('Короткий опис статті про щось'),
                new Description('Повний опис статті про щось'),
                new DateTime(),
                new DateTime()
            ),
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param article image is invalid');
        
        new Article(
            $id,
            true,
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );
    }

    public function testConstructThrowsErrorInvalidAudioNotActive(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), false);
        $author = new Author(new AuthorId('1'), true);
        $image  = new Image(new ImageId(1), true);

        $categories = [
            new Category(
                new CategoryId('cat-1'),
                true,
                1
            ),
        ];

        $languages = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];

        $translates = [
            new Translate(
                new LanguageId('en'),
                new Name('some name'),
                new ShortDescription('Some article short description'),
                new Description('Some article description'),
                new DateTime(),
                new DateTime()
            ),
            new Translate(
                new LanguageId('uk'),
                new Name('Стаття про щось'),
                new ShortDescription('Короткий опис статті про щось'),
                new Description('Повний опис статті про щось'),
                new DateTime(),
                new DateTime()
            ),
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param article audio is not active');

        new Article(
            $id,
            true,
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );
    }

        public function testConstructThrowsErrorInvalidAudioNull(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = null;
        $author = new Author(new AuthorId('1'), true);
        $image  = new Image(new ImageId(1), true);

        $categories = [
            new Category(
                new CategoryId('cat-1'),
                true,
                1
            ),
        ];

        $languages = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];

        $translates = [
            new Translate(
                new LanguageId('en'),
                new Name('some name'),
                new ShortDescription('Some article short description'),
                new Description('Some article description'),
                new DateTime(),
                new DateTime()
            ),
            new Translate(
                new LanguageId('uk'),
                new Name('Стаття про щось'),
                new ShortDescription('Короткий опис статті про щось'),
                new Description('Повний опис статті про щось'),
                new DateTime(),
                new DateTime()
            ),
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param article audio is invalid');

        new Article(
            $id,
            true,
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );
    }

    
}
