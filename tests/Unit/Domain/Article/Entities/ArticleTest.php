<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Article\Entities;

use DateTime;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Article\Article;
use Romchik38\Site2\Domain\Article\CouldNotChangeActivityException;
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
use Romchik38\Site2\Domain\Author\VO\Name as AuthorName;
use Romchik38\Site2\Domain\Category\VO\Identifier as CategoryId;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use stdClass;

final class ArticleTest extends TestCase
{
    public function testCreate(): void
    {
        $id        = new ArticleId('some-id');
        $author    = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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
        $author    = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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
        $author    = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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
        $author    = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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

    public function testConstructThrowsErrorMissingTranslate(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Article has missing translates');

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

    public function testConstructThrowsErrorWrongTranslateInstance(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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
            new stdClass(),
            new stdClass(),
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param article translate is invalid');

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

    public function testConstructThrowsErrorWrongTranslateLanguage(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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
                new LanguageId('fr'),
                new Name('Article sur quelque chose'),
                new ShortDescription('Une brève description d\'un article sur quelque chose'),
                new Description('Une description complète d\'un article sur quelque chose'),
                new DateTime(),
                new DateTime()
            ),
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param article translate language has non expected language');

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

    public function testConstructThrowsErrorNotValidCategory(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
        $image  = new Image(new ImageId(1), true);

        $categories = [
            new stdClass(),
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
        $this->expectExceptionMessage('param article category is invalid');

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

    public function testConstructThrowsErrorNotValidLanguage(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
        $image  = new Image(new ImageId(1), true);

        $categories = [
            new Category(
                new CategoryId('cat-1'),
                true,
                1
            ),
        ];

        $languages = [
            new stdClass(),
            new stdClass(),
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
        $this->expectExceptionMessage('param article language id is invalid');

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

    public function testConstructThrowsErrorAuthorNotActive(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), false, new AuthorName('Author 1'));
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
        $this->expectExceptionMessage('param article author is not active');

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

    public function testActivate(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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
            false,
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );

        $this->assertSame(false, $article->active);
        $article->activate();
        $this->assertSame(true, $article->active);
    }

    public function testActivateThrowsErrorImageNotSet(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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

        $article = new Article(
            $id,
            false,
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $this->expectExceptionMessage('Could not activate article: image not set');

        $article->activate();
    }

    public function testActivateThrowsErrorImageNotActive(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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

        $article = new Article(
            $id,
            false,
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $this->expectExceptionMessage('Could not activate article: image is not active');

        $article->activate();
    }

    public function testActivateThrowsErrorAudioNotSet(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = null;
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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
            false,
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $this->expectExceptionMessage('Could not activate article: audio not set');

        $article->activate();
    }

    public function testActivateThrowsErrorAudioNotActive(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), false);
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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
            false,
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $this->expectExceptionMessage('Could not activate article: audio is not active');

        $article->activate();
    }

    public function testActivateThrowsErrorAuthorNotActive(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), false, new AuthorName('Author 1'));
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
            false,
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $this->expectExceptionMessage('Could not activate article: author is not active');

        $article->activate();
    }

    public function testActivateThrowsErrorNotAllTranslates(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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
        ];

        $article = new Article(
            $id,
            false,
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $this->expectExceptionMessage('Article has missing translates');

        $article->activate();
    }

    public function testActivateThrowsErrorNotInCategory(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
        $image  = new Image(new ImageId(1), true);

        $categories = [];

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
            false,
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $this->expectExceptionMessage('Article must be at least in one category');

        $article->activate();
    }

    /**
     * Tested:
     *   - addTranslate
     *   - getTranslate
     */
    public function testAddTranslate(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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

        $translateUk = new Translate(
            new LanguageId('uk'),
            new Name('Стаття про щось'),
            new ShortDescription('Короткий опис статті про щось'),
            new Description('Повний опис статті про щось'),
            new DateTime(),
            new DateTime()
        );
        $translateEn = new Translate(
            new LanguageId('en'),
            new Name('some name'),
            new ShortDescription('Some article short description'),
            new Description('Some article description'),
            new DateTime(),
            new DateTime()
        );

        $translates = [$translateEn];

        $article = new Article(
            $id,
            false,
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );

        $article->addTranslate($translateUk);
        $this->assertSame($translateUk, $article->getTranslate('uk'));
    }

    public function testAddTranslateThrowsErrorWrongLanguage(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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

        $translateFr = new Translate(
            new LanguageId('fr'),
            new Name('Article sur quelque chose'),
            new ShortDescription('Une brève description d\'un article sur quelque chose'),
            new Description('Une description complète d\'un article sur quelque chose'),
            new DateTime(),
            new DateTime()
        );
        $translateEn = new Translate(
            new LanguageId('en'),
            new Name('some name'),
            new ShortDescription('Some article short description'),
            new Description('Some article description'),
            new DateTime(),
            new DateTime()
        );

        $translates = [$translateEn];

        $article = new Article(
            $id,
            false,
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param article translate language has non expected language');

        $article->addTranslate($translateFr);
    }

    public function testChangeAuthor(): void
    {
        $id      = new ArticleId('some-id');
        $audio   = new Audio(new AudioId(1), true);
        $author  = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
        $author2 = new Author(new AuthorId('2'), true, new AuthorName('Author 2'));
        $image   = new Image(new ImageId(1), true);

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
            false,
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );

        $article->changeAuthor($author2);
        $this->assertSame($author2, $article->author);
    }

    public function testChangeAuthorThrowsErrorNotActiveAuthor(): void
    {
        $id      = new ArticleId('some-id');
        $audio   = new Audio(new AudioId(1), true);
        $author  = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
        $author2 = new Author(new AuthorId('2'), false, new AuthorName('Author 2'));
        $image   = new Image(new ImageId(1), true);

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
            true, // the article must be active to pass this check
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Article author not active');

        $article->changeAuthor($author2);
    }

    public function testChangeImage(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
        $image  = new Image(new ImageId(1), true);
        $image2 = new Image(new ImageId(2), true);

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
            false,
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );

        $article->changeImage($image2);
        $this->assertSame($image2, $article->image);
    }

    public function testChangeImageThrowsErrorImageNotActive(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
        $image  = new Image(new ImageId(1), true);
        $image2 = new Image(new ImageId(2), false);

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
            true, // the article must be active to pass this check
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Article image not active');

        $article->changeImage($image2);
    }

    public function testChangeAudio(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $audio2 = new Audio(new AudioId(2), true);
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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
            false,
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );

        $article->changeAudio($audio2);
        $this->assertSame($audio2, $article->audio);
    }

    public function testChangeAudioThrowsErrorNotActiveAudio(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $audio2 = new Audio(new AudioId(2), false);
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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
            true, // must be true to pass check
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Article audio not active');

        $article->changeAudio($audio2);
    }

    public function testDeactivate(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
        $image  = new Image(new ImageId(1), true);

        $categories = [
            new Category(
                new CategoryId('cat-1'),
                true,
                2
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

        $this->assertSame(true, $article->active);
        $article->deactivate();
        $this->assertSame(false, $article->active);
    }

    public function testDeactivateThrowErrorOnlyOneInCategory(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
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

        $this->expectException(CouldNotChangeActivityException::class);
        $this->expectExceptionMessage('Category cat-1 is active and has only one article');

        $article->deactivate();
    }

    public function testGetCategories(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
        $image  = new Image(new ImageId(1), true);

        $categories = [
            new Category(new CategoryId('cat-1'), true, 1),
            new Category(new CategoryId('cat-2'), true, 5),
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
            false,
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );

        $this->assertSame($categories, $article->getCategories());
    }

    public function testGetTranslate(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
        $image  = new Image(new ImageId(1), true);

        $categories = [
            new Category(new CategoryId('cat-1'), true, 1),
            new Category(new CategoryId('cat-2'), true, 5),
        ];

        $languages = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];

        $translateEn = new Translate(
            new LanguageId('en'),
            new Name('some name'),
            new ShortDescription('Some article short description'),
            new Description('Some article description'),
            new DateTime(),
            new DateTime()
        );
        $translateUk = new Translate(
            new LanguageId('uk'),
            new Name('Стаття про щось'),
            new ShortDescription('Короткий опис статті про щось'),
            new Description('Повний опис статті про щось'),
            new DateTime(),
            new DateTime()
        );

        $translates = [$translateEn, $translateUk];

        $article = new Article(
            $id,
            false,
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );

        $this->assertSame($translateEn, $article->getTranslate('en'));
        $this->assertSame($translateUk, $article->getTranslate('uk'));
    }

    public function testGetTranslates(): void
    {
        $id     = new ArticleId('some-id');
        $audio  = new Audio(new AudioId(1), true);
        $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
        $image  = new Image(new ImageId(1), true);

        $categories = [
            new Category(new CategoryId('cat-1'), true, 1),
            new Category(new CategoryId('cat-2'), true, 5),
        ];

        $languages = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];

        $translateEn = new Translate(
            new LanguageId('en'),
            new Name('some name'),
            new ShortDescription('Some article short description'),
            new Description('Some article description'),
            new DateTime(),
            new DateTime()
        );
        $translateUk = new Translate(
            new LanguageId('uk'),
            new Name('Стаття про щось'),
            new ShortDescription('Короткий опис статті про щось'),
            new Description('Повний опис статті про щось'),
            new DateTime(),
            new DateTime()
        );

        $translates = [$translateEn, $translateUk];

        $article = new Article(
            $id,
            false,
            $audio,
            $author,
            $image,
            $categories,
            $languages,
            $translates
        );

        $this->assertSame($translates, $article->getTranslates());
    }

    // public function testActivateThrowsErrorImageNotSet(): void
    // {
    //     $id     = new ArticleId('some-id');
    //     $audio  = new Audio(new AudioId(1), true);
    //     $author = new Author(new AuthorId('1'), true, new AuthorName('Author 1'));
    //     $image  = new Image(new ImageId(1), true);

    //     $categories = [
    //         new Category(
    //             new CategoryId('cat-1'),
    //             true,
    //             1
    //         ),
    //     ];

    //     $languages = [
    //         new LanguageId('en'),
    //         new LanguageId('uk'),
    //     ];

    //     $translates = [
    //         new Translate(
    //             new LanguageId('en'),
    //             new Name('some name'),
    //             new ShortDescription('Some article short description'),
    //             new Description('Some article description'),
    //             new DateTime(),
    //             new DateTime()
    //         ),
    //         new Translate(
    //             new LanguageId('uk'),
    //             new Name('Стаття про щось'),
    //             new ShortDescription('Короткий опис статті про щось'),
    //             new Description('Повний опис статті про щось'),
    //             new DateTime(),
    //             new DateTime()
    //         ),
    //     ];

    //     $article = new Article(
    //         $id,
    //         false,
    //         $audio,
    //         $author,
    //         $image,
    //         $categories,
    //         $languages,
    //         $translates
    //     );

    //     $this->expectException(CouldNotChangeActivityException::class);
    //     $this->expectExceptionMessage('');

    //     $article->activate();
    // }
}
