<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Image;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Article\VO\ArticleId;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Image\Entities\Article;
use Romchik38\Site2\Domain\Image\Entities\Content;
use Romchik38\Site2\Domain\Image\Entities\Translate;
use Romchik38\Site2\Domain\Image\Image;
use Romchik38\Site2\Domain\Image\VO\Description;
use Romchik38\Site2\Domain\Image\VO\Name;
use Romchik38\Site2\Domain\Image\VO\Path;
use Romchik38\Site2\Domain\Image\VO\Type;
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
     *   getName
     *   getPath
     *   getTranslate
     *   getTranslates
     *   getArticles
     */
    public function testCreate(): void
    {
        $name       = new Name('image-name-1');
        $authorId   = new AuthorId('25');
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
            $authorId,
            $path,
            $languages,
            $translates
        );

        $this->assertSame('image-name-1', (string) $image->getName());
        $this->assertSame('25', (string) $image->getAuthor());
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
        $authorId   = new AuthorId('25');
        $path       = new Path('/images/img1.webp');
        $languages  = [ 1, 3];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Blue sky')),
            new Translate(new LanguageId('uk'), new Description('Блакитне небо')),
        ];

        $this->expectException(InvalidArgumentException::class);

        Image::create(
            $name,
            $authorId,
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
        $authorId   = new AuthorId('25');
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('fr'), new Description('Blue sky')),   // Invalid language
            new Translate(new LanguageId('uk'), new Description('Блакитне небо')),
        ];

        $this->expectException(InvalidArgumentException::class);

        Image::create(
            $name,
            $authorId,
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
        $authorId   = new AuthorId('25');
        $path       = new Path('/images/img1.webp');
        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new stdClass(),                             // Invalid Translate instance
            new Translate(new LanguageId('uk'), new Description('Блакитне небо')),
        ];

        $this->expectException(InvalidArgumentException::class);

        Image::create(
            $name,
            $authorId,
            $path,
            $languages,
            $translates
        );
    }

    public function testGetContent(): void
    {
        $name       = new Name('image-name-1');
        $authorId   = new AuthorId('25');
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
            $authorId,
            $path,
            $languages,
            $translates
        );

        $data = imagecreatetruecolor(1,1);
        $content = new Content($data, new Type('webp'));
        $image->loadContent($content);

        $this->assertSame($content, $image->getContent());
    }

    public function testGetContentReturnNull(): void
    {
        $name       = new Name('image-name-1');
        $authorId   = new AuthorId('25');
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
            $authorId,
            $path,
            $languages,
            $translates
        );

        $this->assertSame(null, $image->getContent());
    }

    public function testChangePath(): void
    {
        $name       = new Name('image-name-1');
        $authorId   = new AuthorId('25');
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
            $authorId,
            $path,
            $languages,
            $translates
        );

        $newPath = new Path('/images/houses/img1.webp');
        $image->changePath($newPath);
        $this->assertSame($newPath, $image->getPath());
    }
}
