<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Image;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Banner\VO\Identifier as BannerId;
use Romchik38\Site2\Domain\Image\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\Image\Entities\Article;
use Romchik38\Site2\Domain\Image\Entities\Author;
use Romchik38\Site2\Domain\Image\Entities\Banner;
use Romchik38\Site2\Domain\Image\Entities\Content;
use Romchik38\Site2\Domain\Image\Entities\Translate;
use Romchik38\Site2\Domain\Image\Image;
use Romchik38\Site2\Domain\Image\VO\Description;
use Romchik38\Site2\Domain\Image\VO\Height;
use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Domain\Image\VO\Name;
use Romchik38\Site2\Domain\Image\VO\Path;
use Romchik38\Site2\Domain\Image\VO\Size;
use Romchik38\Site2\Domain\Image\VO\Type;
use Romchik38\Site2\Domain\Image\VO\Width;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use stdClass;

use function count;
use function imagecreatetruecolor;

final class ImageTest extends TestCase
{
    /**
     * Tested:
     *   create
     *   getAuthor
     *   getId
     *   getName
     *   getPath
     *   getTranslate
     *   getTranslates
     *   getArticles
     */
    public function testCreate(): void
    {
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
            new Translate(new LanguageId('uk'), new Description('Блакитне небо')),
        ];
        $image      = Image::create(
            $name,
            $author,
            $path,
            $languages,
            $translates
        );

        $this->assertSame(null, $image->getId());
        $this->assertSame('image-name-1', (string) $image->getName());
        $this->assertSame($author, $image->getAuthor());
        $this->assertSame('/images/img1.webp', (string) $image->getPath());

        $translates = $image->getTranslates();
        $this->assertSame(2, count($translates));
        $t1 = $image->getTranslate('en');
        $t2 = $image->getTranslate('uk');
        $this->assertSame('en', (string) $t1->getLanguage());
        $this->assertSame('Blue sky', (string) $t1->getDescription());
        $this->assertSame('uk', (string) $t2->getLanguage());
        $this->assertSame('Блакитне небо', (string) $t2->getDescription());
        $this->assertSame([], $image->getArticles());
    }

     /**
      * Tested:
      *   __construct
      */
    public function testCreateThrowsErrorInvalidLanguages(): void
    {
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [1, 3];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
            new Translate(new LanguageId('uk'), new Description('Блакитне небо')),
        ];

        $this->expectException(InvalidArgumentException::class);

        Image::create(
            $name,
            $author,
            $path,
            $languages,
            $translates
        );
    }

    /**
     * Tested:
     *   __construct
     */
    public function testCreateThrowsErrorInvalidTranslateLanguage(): void
    {
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('fr'), new Description('Blue sky')), // Invalid language
            new Translate(new LanguageId('uk'), new Description('Блакитне небо')),
        ];

        $this->expectException(InvalidArgumentException::class);

        Image::create(
            $name,
            $author,
            $path,
            $languages,
            $translates
        );
    }

    /**
     * Tested:
     *   __construct
     */
    public function testCreateThrowsErrorInvalidTranslate(): void
    {
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new stdClass(), // Invalid Translate instance
            new Translate(new LanguageId('uk'), new Description('Блакитне небо')),
        ];

        $this->expectException(InvalidArgumentException::class);

        Image::create(
            $name,
            $author,
            $path,
            $languages,
            $translates
        );
    }

    /**
     * Tested:
     *  loadContent
     *  getContent
     */
    public function testGetContent(): void
    {
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
            new Translate(new LanguageId('uk'), new Description('Блакитне небо')),
        ];

        $image = Image::create(
            $name,
            $author,
            $path,
            $languages,
            $translates
        );

        $data    = imagecreatetruecolor(1, 1);
        $content = new Content(
            $data,
            new Type('webp'),
            new Height(1100),
            new Width(1100),
            new Size(35200)
        );
        $image->loadContent($content);

        $this->assertSame($content, $image->getContent());
    }

    public function testGetContentReturnNull(): void
    {
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
            new Translate(new LanguageId('uk'), new Description('Блакитне небо')),
        ];

        $image = Image::create(
            $name,
            $author,
            $path,
            $languages,
            $translates
        );

        $this->assertSame(null, $image->getContent());
    }

    public function testReName(): void
    {
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
            new Translate(new LanguageId('uk'), new Description('Блакитне небо')),
        ];
        $image      = Image::create(
            $name,
            $author,
            $path,
            $languages,
            $translates
        );

        $newName = new Name('image-name-2');
        $image->reName($newName);
        $this->assertSame($newName, $image->getName());
    }

    /**
     * Tests
     *   __constract
     *   getId
     *   isActive
     *   getName
     *   getAuthor
     *   getPath
     *   getArticles
     *   getTranslates
     */
    public function testLoad(): void
    {
        $id         = new Id(1);
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
            new Translate(new LanguageId('uk'), new Description('Блакитне небо')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), true),
        ];
        $banners  = [];

        $image = Image::load(
            $id,
            true,
            $name,
            $author,
            $path,
            $languages,
            $articles,
            $banners,
            $translates
        );

        $t1 = $image->getTranslate('en');
        $t2 = $image->getTranslate('uk');

        $this->assertSame($id, $image->getId());
        $this->assertSame(true, $image->isActive());
        $this->assertSame($name, $image->getName());
        $this->assertSame($author, $image->getAuthor());
        $this->assertSame($path, $image->getPath());
        $this->assertSame($articles, $image->getArticles());
        $this->assertSame(2, count($image->getTranslates()));
        $this->assertSame('Blue sky', (string) $t1->getDescription());
        $this->assertSame('Блакитне небо', (string) $t2->getDescription());
    }

    public function testLoadActiveArticleAndNotActiveImage(): void
    {
        $id         = new Id(1);
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
            new Translate(new LanguageId('uk'), new Description('Блакитне небо')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), true), // wrong
        ];
        $banners  = [];

        $this->expectException(InvalidArgumentException::class);

        Image::load(
            $id,
            false, // wrong
            $name,
            $author,
            $path,
            $languages,
            $articles,
            $banners,
            $translates
        );
    }

    public function testLoadThrowsErrorInvalidArticle(): void
    {
        $id         = new Id(1);
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
            new Translate(new LanguageId('uk'), new Description('Блакитне небо')),
        ];

        $articles = [
            'some string', // wrong
        ];
        $banners  = [];

        $this->expectException(InvalidArgumentException::class);

        Image::load(
            $id,
            false,
            $name,
            $author,
            $path,
            $languages,
            $articles,
            $banners,
            $translates
        );
    }

    public function testActivate(): void
    {
        $id         = new Id(1);
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
            new Translate(new LanguageId('uk'), new Description('Блакитне небо')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];
        $banners  = [];

        $image = Image::load(
            $id,
            false,
            $name,
            $author,
            $path,
            $languages,
            $articles,
            $banners,
            $translates
        );

        $data    = imagecreatetruecolor(1, 1);
        $content = new Content(
            $data,
            new Type('webp'),
            new Height(1100),
            new Width(1100),
            new Size(35200)
        );
        $image->loadContent($content);

        $image->activate();
        $this->assertSame(true, $image->isActive());
    }

    public function testActivateThrowsErrorOnMissingTranslate(): void
    {
        $id         = new Id(1);
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];
        $banners  = [];

        $image = Image::load(
            $id,
            false,
            $name,
            $author,
            $path,
            $languages,
            $articles,
            $banners,
            $translates
        );

        $data    = imagecreatetruecolor(1, 1);
        $content = new Content(
            $data,
            new Type('webp'),
            new Height(1100),
            new Width(1100),
            new Size(35200)
        );
        $image->loadContent($content);

        $this->expectException(CouldNotChangeActivityException::class);
        $image->activate();
    }

    public function testActivateThrowsErrorOnCreate(): void
    {
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
            new Translate(new LanguageId('uk'), new Description('Блакитне небо')),
        ];
        $image      = Image::create(
            $name,
            $author,
            $path,
            $languages,
            $translates
        );

        $data    = imagecreatetruecolor(1, 1);
        $content = new Content(
            $data,
            new Type('webp'),
            new Height(1100),
            new Width(1100),
            new Size(35200)
        );
        $image->loadContent($content);

        $this->expectException(CouldNotChangeActivityException::class);
        $image->activate();
    }

    public function testActivateThrowsErrorImageNotLoaded(): void
    {
        $id         = new Id(1);
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
            new Translate(new LanguageId('uk'), new Description('Blue sky')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];
        $banners  = [];

        $image = Image::load(
            $id,
            false,
            $name,
            $author,
            $path,
            $languages,
            $articles,
            $banners,
            $translates
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $image->activate();
    }

    public function testActivateThrowsErrorAuthorNotActive(): void
    {
        $id         = new Id(1);
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            false
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
            new Translate(new LanguageId('uk'), new Description('Blue sky')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];
        $banners  = [];

        $image = Image::load(
            $id,
            false,
            $name,
            $author,
            $path,
            $languages,
            $articles,
            $banners,
            $translates
        );

        $data    = imagecreatetruecolor(1, 1);
        $content = new Content(
            $data,
            new Type('webp'),
            new Height(1100),
            new Width(1100),
            new Size(35200)
        );
        $image->loadContent($content);

        $this->expectException(CouldNotChangeActivityException::class);
        $image->activate();
    }

    public function testAddTranslateWithNonExistingLanguage(): void
    {
        $id         = new Id(1);
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];
        $banners  = [];

        $image = Image::load(
            $id,
            false,
            $name,
            $author,
            $path,
            $languages,
            $articles,
            $banners,
            $translates
        );

        $addedTranslate = new Translate(new LanguageId('uk'), new Description('Блакитне небо'));
        $image->addTranslate($addedTranslate);
        $this->assertSame($addedTranslate, $image->getTranslate('uk'));
    }

    public function testAddTranslateRewriteExisting(): void
    {
        $id         = new Id(1);
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];
        $banners  = [];

        $image = Image::load(
            $id,
            false,
            $name,
            $author,
            $path,
            $languages,
            $articles,
            $banners,
            $translates
        );

        $rewritedTranslate = new Translate(new LanguageId('en'), new Description('Blue sky 1'));
        $image->addTranslate($rewritedTranslate);
        $this->assertSame($rewritedTranslate, $image->getTranslate('en'));
    }

    public function testAddTranslateThrowsErrorOnWrongLanguage(): void
    {
        $id         = new Id(1);
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];
        $banners  = [];

        $image = Image::load(
            $id,
            false,
            $name,
            $author,
            $path,
            $languages,
            $articles,
            $banners,
            $translates
        );

        $addedTranslate = new Translate(new LanguageId('fr'), new Description('Блакитне небо'));

        $this->expectException(InvalidArgumentException::class);
        $image->addTranslate($addedTranslate);
    }

    public function testDeactivate(): void
    {
        $id         = new Id(1);
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
            new Translate(new LanguageId('uk'), new Description('Блакитне небо')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];
        $banners  = [];

        $image = Image::load(
            $id,
            true,
            $name,
            $author,
            $path,
            $languages,
            $articles,
            $banners,
            $translates
        );

        $image->deactivate();
        $this->assertSame(false, $image->isActive());
    }

    public function testDeactivateThrowsErrorOnExistingActiveArticle(): void
    {
        $id         = new Id(1);
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
            new Translate(new LanguageId('uk'), new Description('Блакитне небо')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), true),
        ];
        $banners  = [];

        $image = Image::load(
            $id,
            true,
            $name,
            $author,
            $path,
            $languages,
            $articles,
            $banners,
            $translates
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $image->deactivate();
    }

    public function testChangeAuthorWhenActive(): void
    {
        $id         = new Id(1);
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
            new Translate(new LanguageId('uk'), new Description('Блакитне небо')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];
        $banners  = [];

        $image = Image::load(
            $id,
            true,
            $name,
            $author,
            $path,
            $languages,
            $articles,
            $banners,
            $translates
        );

        // 1. Success
        $newAuthor = new Author(
            new AuthorId(26),
            true
        );
        $image->changeAuthor($newAuthor);
        $this->assertSame($newAuthor, $image->getAuthor());

        // 2. Exception
        $newAuthor2 = new Author(
            new AuthorId(27),
            false
        );
        $this->expectException(InvalidArgumentException::class);
        $image->changeAuthor($newAuthor2);
    }

    public function testChangeAuthorWhenNonActive(): void
    {
        $id         = new Id(1);
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
            new Translate(new LanguageId('uk'), new Description('Блакитне небо')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];
        $banners  = [];

        $image = Image::load(
            $id,
            false,
            $name,
            $author,
            $path,
            $languages,
            $articles,
            $banners,
            $translates
        );

        // 1. Success
        $newAuthor = new Author(
            new AuthorId(26),
            true
        );
        $image->changeAuthor($newAuthor);
        $this->assertSame($newAuthor, $image->getAuthor());

        // 2. Also success
        $newAuthor2 = new Author(
            new AuthorId(27),
            false
        );
        $image->changeAuthor($newAuthor2);
        $this->assertSame($newAuthor2, $image->getAuthor());
    }

    public function testLoadThrowsErrorInvalidBanner(): void
    {
        $id         = new Id(1);
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
            new Translate(new LanguageId('uk'), new Description('Блакитне небо')),
        ];

        $articles = [];
        $banners  = ['some string']; // wrong

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param image banner is invalid');

        Image::load(
            $id,
            false,
            $name,
            $author,
            $path,
            $languages,
            $articles,
            $banners,
            $translates
        );
    }

    public function testLoadThrowsErrorActiveBannerButNonActiveImage(): void
    {
        $id         = new Id(1);
        $name       = new Name('image-name-1');
        $author     = new Author(
            new AuthorId(25),
            true
        );
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
            new Translate(new LanguageId('uk'), new Description('Блакитне небо')),
        ];

        $articles = [];
        $banners  = [
            new Banner(new BannerId(1), true), //  wrong
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('params image banner active and image active are different');

        Image::load(
            $id,
            false, // wrong
            $name,
            $author,
            $path,
            $languages,
            $articles,
            $banners,
            $translates
        );
    }
}
