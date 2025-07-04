<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Article;

use DateTime;
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
use Romchik38\Site2\Domain\Article\VO\Views;
use Romchik38\Site2\Domain\Audio\VO\Id as AudioId;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Name as AuthorName;
use Romchik38\Site2\Domain\Category\VO\Identifier as CategoryId;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class ArticleUpdateTest extends TestCase
{
    public function testAddTranslateUpdateWhenNewAdded(): void
    {
        $id        = new ArticleId('some-id');
        $audio     = new Audio(new AudioId(1), true);
        $author    = new Author(new AuthorId(1), true, new AuthorName('Author 1'));
        $image     = new Image(new ImageId(1), true);
        $createdAt = new DateTime();
        $updatedAt = new DateTime();
        $views     = new Views(0);

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
            new DateTime()
        );
        $translateEn = new Translate(
            new LanguageId('en'),
            new Name('some name'),
            new ShortDescription('Some article short description'),
            new Description('Some article description'),
            new DateTime()
        );

        $translates = [$translateEn];

        $article = new Article(
            $id,
            false,
            $audio,
            $author,
            $image,
            $createdAt,
            $updatedAt,
            $views,
            $categories,
            $languages,
            $translates
        );

        $this->assertSame($updatedAt, $article->updatedAt);
        $article->addTranslate($translateUk);
        $this->assertNotEquals($updatedAt, $article->updatedAt);
    }

    public function testAddTranslateUpdateWhenChangedName(): void
    {
        $id        = new ArticleId('some-id');
        $audio     = new Audio(new AudioId(1), true);
        $author    = new Author(new AuthorId(1), true, new AuthorName('Author 1'));
        $image     = new Image(new ImageId(1), true);
        $createdAt = new DateTime();
        $updatedAt = new DateTime();
        $views     = new Views(0);

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

        $translateUk    = new Translate(
            new LanguageId('uk'),
            new Name('Стаття про щось'),
            new ShortDescription('Короткий опис статті про щось'),
            new Description('Повний опис статті про щось'),
            new DateTime()
        );
        $translateUkNew = new Translate(
            new LanguageId('uk'),
            new Name('Стаття про щось 1'),
            new ShortDescription('Короткий опис статті про щось'),
            new Description('Повний опис статті про щось'),
            new DateTime()
        );
        $translateEn    = new Translate(
            new LanguageId('en'),
            new Name('some name'),
            new ShortDescription('Some article short description'),
            new Description('Some article description'),
            new DateTime()
        );

        $translates = [$translateEn, $translateUk];

        $article = new Article(
            $id,
            false,
            $audio,
            $author,
            $image,
            $createdAt,
            $updatedAt,
            $views,
            $categories,
            $languages,
            $translates
        );

        $this->assertSame($updatedAt, $article->updatedAt);
        $article->addTranslate($translateUkNew);
        $this->assertNotEquals($updatedAt, $article->updatedAt);
    }

    public function testAddTranslateUpdateWhenChangedShortDesc(): void
    {
        $id        = new ArticleId('some-id');
        $audio     = new Audio(new AudioId(1), true);
        $author    = new Author(new AuthorId(1), true, new AuthorName('Author 1'));
        $image     = new Image(new ImageId(1), true);
        $createdAt = new DateTime();
        $updatedAt = new DateTime();
        $views     = new Views(0);

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

        $translateUk    = new Translate(
            new LanguageId('uk'),
            new Name('Стаття про щось'),
            new ShortDescription('Короткий опис статті про щось'),
            new Description('Повний опис статті про щось'),
            new DateTime()
        );
        $translateUkNew = new Translate(
            new LanguageId('uk'),
            new Name('Стаття про щось'),
            new ShortDescription('Короткий опис статті про щось 1'),
            new Description('Повний опис статті про щось'),
            new DateTime()
        );
        $translateEn    = new Translate(
            new LanguageId('en'),
            new Name('some name'),
            new ShortDescription('Some article short description'),
            new Description('Some article description'),
            new DateTime()
        );

        $translates = [$translateEn, $translateUk];

        $article = new Article(
            $id,
            false,
            $audio,
            $author,
            $image,
            $createdAt,
            $updatedAt,
            $views,
            $categories,
            $languages,
            $translates
        );

        $this->assertSame($updatedAt, $article->updatedAt);
        $article->addTranslate($translateUkNew);
        $this->assertNotEquals($updatedAt, $article->updatedAt);
    }

    public function testAddTranslateUpdateWhenChangedDescription(): void
    {
        $id        = new ArticleId('some-id');
        $audio     = new Audio(new AudioId(1), true);
        $author    = new Author(new AuthorId(1), true, new AuthorName('Author 1'));
        $image     = new Image(new ImageId(1), true);
        $createdAt = new DateTime();
        $updatedAt = new DateTime();
        $views     = new Views(0);

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

        $translateUk    = new Translate(
            new LanguageId('uk'),
            new Name('Стаття про щось'),
            new ShortDescription('Короткий опис статті про щось'),
            new Description('Повний опис статті про щось'),
            new DateTime()
        );
        $translateUkNew = new Translate(
            new LanguageId('uk'),
            new Name('Стаття про щось'),
            new ShortDescription('Короткий опис статті про щось'),
            new Description('Повний опис статті про щось 1'),
            new DateTime()
        );
        $translateEn    = new Translate(
            new LanguageId('en'),
            new Name('some name'),
            new ShortDescription('Some article short description'),
            new Description('Some article description'),
            new DateTime()
        );

        $translates = [$translateEn, $translateUk];

        $article = new Article(
            $id,
            false,
            $audio,
            $author,
            $image,
            $createdAt,
            $updatedAt,
            $views,
            $categories,
            $languages,
            $translates
        );

        $this->assertSame($updatedAt, $article->updatedAt);
        $article->addTranslate($translateUkNew);
        $this->assertNotEquals($updatedAt, $article->updatedAt);
    }

    public function testChangeAudioUpdate(): void
    {
        $id        = new ArticleId('some-id');
        $audio     = new Audio(new AudioId(1), true);
        $audio2    = new Audio(new AudioId(2), true);
        $author    = new Author(new AuthorId(1), true, new AuthorName('Author 1'));
        $image     = new Image(new ImageId(1), true);
        $createdAt = new DateTime();
        $updatedAt = new DateTime();
        $views     = new Views(0);

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
            new DateTime()
        );
        $translateEn = new Translate(
            new LanguageId('en'),
            new Name('some name'),
            new ShortDescription('Some article short description'),
            new Description('Some article description'),
            new DateTime()
        );

        $translates = [$translateEn, $translateUk];

        $article = new Article(
            $id,
            false,
            $audio,
            $author,
            $image,
            $createdAt,
            $updatedAt,
            $views,
            $categories,
            $languages,
            $translates
        );

        $this->assertSame($updatedAt, $article->updatedAt);
        $article->changeAudio($audio2);
        $this->assertNotEquals($updatedAt, $article->updatedAt);
    }

    public function testChangeAudioDoNOtUpdate(): void
    {
        $id        = new ArticleId('some-id');
        $audio     = new Audio(new AudioId(1), true);
        $author    = new Author(new AuthorId(1), true, new AuthorName('Author 1'));
        $image     = new Image(new ImageId(1), true);
        $createdAt = new DateTime();
        $updatedAt = new DateTime();
        $views     = new Views(0);

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
            new DateTime()
        );
        $translateEn = new Translate(
            new LanguageId('en'),
            new Name('some name'),
            new ShortDescription('Some article short description'),
            new Description('Some article description'),
            new DateTime()
        );

        $translates = [$translateEn, $translateUk];

        $article = new Article(
            $id,
            false,
            $audio,
            $author,
            $image,
            $createdAt,
            $updatedAt,
            $views,
            $categories,
            $languages,
            $translates
        );

        $this->assertSame($updatedAt, $article->updatedAt);
        $article->changeAudio($audio);
        $this->assertSame($updatedAt, $article->updatedAt);
    }

    public function testChangeAudioWhenItWasNotSet(): void
    {
        $id        = new ArticleId('some-id');
        $author    = new Author(new AuthorId(1), true, new AuthorName('Author 1'));
        $createdAt = new DateTime();
        $audio     = new Audio(new AudioId(1), true);

        $languages = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];

        $article = Article::create(
            $id,
            $author,
            $languages,
            null,
            null,
            $createdAt
        );

        $oldUpdatedAt = $article->updatedAt;
        $article->changeAudio($audio);
        $this->assertNotEquals($oldUpdatedAt, $article->updatedAt);
    }

    public function testChangeAuthorUpdate(): void
    {
        $id        = new ArticleId('some-id');
        $audio     = new Audio(new AudioId(1), true);
        $author    = new Author(new AuthorId(1), true, new AuthorName('Author 1'));
        $author2   = new Author(new AuthorId(2), true, new AuthorName('Author 2'));
        $image     = new Image(new ImageId(1), true);
        $createdAt = new DateTime();
        $updatedAt = new DateTime();
        $views     = new Views(0);

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
            new DateTime()
        );
        $translateEn = new Translate(
            new LanguageId('en'),
            new Name('some name'),
            new ShortDescription('Some article short description'),
            new Description('Some article description'),
            new DateTime()
        );

        $translates = [$translateEn, $translateUk];

        $article = new Article(
            $id,
            false,
            $audio,
            $author,
            $image,
            $createdAt,
            $updatedAt,
            $views,
            $categories,
            $languages,
            $translates
        );

        $this->assertSame($updatedAt, $article->updatedAt);
        $article->changeAuthor($author2);
        $this->assertNotEquals($updatedAt, $article->updatedAt);
    }

    public function testChangeAuthorDoNotUpdate(): void
    {
        $id        = new ArticleId('some-id');
        $audio     = new Audio(new AudioId(1), true);
        $author    = new Author(new AuthorId(1), true, new AuthorName('Author 1'));
        $image     = new Image(new ImageId(1), true);
        $createdAt = new DateTime();
        $updatedAt = new DateTime();
        $views     = new Views(0);

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
            new DateTime()
        );
        $translateEn = new Translate(
            new LanguageId('en'),
            new Name('some name'),
            new ShortDescription('Some article short description'),
            new Description('Some article description'),
            new DateTime()
        );

        $translates = [$translateEn, $translateUk];

        $article = new Article(
            $id,
            false,
            $audio,
            $author,
            $image,
            $createdAt,
            $updatedAt,
            $views,
            $categories,
            $languages,
            $translates
        );

        $this->assertSame($updatedAt, $article->updatedAt);
        $article->changeAuthor($author);
        $this->assertSame($updatedAt, $article->updatedAt);
    }

    public function testChangeImageUpdate(): void
    {
        $id        = new ArticleId('some-id');
        $audio     = new Audio(new AudioId(1), true);
        $author    = new Author(new AuthorId(1), true, new AuthorName('Author 1'));
        $image     = new Image(new ImageId(1), true);
        $image2    = new Image(new ImageId(2), true);
        $createdAt = new DateTime();
        $updatedAt = new DateTime();
        $views     = new Views(0);

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
            new DateTime()
        );
        $translateEn = new Translate(
            new LanguageId('en'),
            new Name('some name'),
            new ShortDescription('Some article short description'),
            new Description('Some article description'),
            new DateTime()
        );

        $translates = [$translateEn, $translateUk];

        $article = new Article(
            $id,
            false,
            $audio,
            $author,
            $image,
            $createdAt,
            $updatedAt,
            $views,
            $categories,
            $languages,
            $translates
        );

        $this->assertSame($updatedAt, $article->updatedAt);
        $article->changeImage($image2);
        $this->assertNotEquals($updatedAt, $article->updatedAt);
    }

    public function testChangeImageNotUpdate(): void
    {
        $id        = new ArticleId('some-id');
        $audio     = new Audio(new AudioId(1), true);
        $author    = new Author(new AuthorId(1), true, new AuthorName('Author 1'));
        $image     = new Image(new ImageId(1), true);
        $createdAt = new DateTime();
        $updatedAt = new DateTime();
        $views     = new Views(0);

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
            new DateTime()
        );
        $translateEn = new Translate(
            new LanguageId('en'),
            new Name('some name'),
            new ShortDescription('Some article short description'),
            new Description('Some article description'),
            new DateTime()
        );

        $translates = [$translateEn, $translateUk];

        $article = new Article(
            $id,
            false,
            $audio,
            $author,
            $image,
            $createdAt,
            $updatedAt,
            $views,
            $categories,
            $languages,
            $translates
        );

        $this->assertSame($updatedAt, $article->updatedAt);
        $article->changeImage($image);
        $this->assertSame($updatedAt, $article->updatedAt);
    }
}
