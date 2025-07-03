<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Article;

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
        $translateUkNew = new Translate(
            new LanguageId('uk'),
            new Name('Стаття про щось 1'),
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
        $translateUkNew = new Translate(
            new LanguageId('uk'),
            new Name('Стаття про щось'),
            new ShortDescription('Короткий опис статті про щось 1'),
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
        $translateUkNew = new Translate(
            new LanguageId('uk'),
            new Name('Стаття про щось'),
            new ShortDescription('Короткий опис статті про щось'),
            new Description('Повний опис статті про щось 1'),
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
            $categories,
            $languages,
            $translates
        );

        $this->assertSame($updatedAt, $article->updatedAt);
        $article->addTranslate($translateUkNew);
        $this->assertNotEquals($updatedAt, $article->updatedAt);
    }        
}
