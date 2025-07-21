<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Author;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Author\Author;
use Romchik38\Site2\Domain\Author\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\Author\Entities\Translate;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Description;
use Romchik38\Site2\Domain\Author\VO\Name;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class AuthorTest extends TestCase
{
    /** also tested:
     *   - getTranslates()
     */
    public function testConstruct(): void
    {
        $id          = new AuthorId(1);
        $name        = new Name('some author');
        $articles    = [new ArticleId('article-1')];
        $images      = [new ImageId(1)];
        $languages   = [new LanguageId('en'), new LanguageId('uk')];
        $translateEn = new Translate(new LanguageId('en'), new Description('some author 1'));
        $translateUk = new Translate(new LanguageId('uk'), new Description('якийсь автор 1'));
        $translates  = [$translateEn, $translateUk];
        $model       = new Author(
            $id,
            $name,
            true,
            $articles,
            $images,
            $languages,
            $translates
        );

        $this->assertSame($id, $model->identifier);
        $this->assertSame($name, $model->name);
        $this->assertSame(true, $model->active);
        $this->assertSame($translates, $model->getTranslates());
    }

    public function testConstructThrowsErrorOnInvalidId(): void
    {
        $id          = null;
        $name        = new Name('some author');
        $articles    = [new ArticleId('article-1')];
        $images      = [new ImageId(1)];
        $languages   = [new LanguageId('en'), new LanguageId('uk')];
        $translateEn = new Translate(new LanguageId('en'), new Description('some author 1'));
        $translateUk = new Translate(new LanguageId('uk'), new Description('якийсь автор 1'));
        $translates  = [$translateEn, $translateUk];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Author::INVALID_ID);

        new Author(
            $id,
            $name,
            true,
            $articles,
            $images,
            $languages,
            $translates
        );
    }

    public function testConstructThrowsErrorOnWrongLanguage(): void
    {
        $id          = new AuthorId(1);
        $name        = new Name('some author');
        $articles    = [new ArticleId('article-1')];
        $images      = [new ImageId(1)];
        $languages   = ['wrong', new LanguageId('uk')]; // wrong
        $translateEn = new Translate(new LanguageId('en'), new Description('some author 1'));
        $translateUk = new Translate(new LanguageId('uk'), new Description('якийсь автор 1'));
        $translates  = [$translateEn, $translateUk];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param language is not valid');

        new Author(
            $id,
            $name,
            true,
            $articles,
            $images,
            $languages,
            $translates
        );
    }

    public function testConstructThrowsErrorOnEmptyLanguage(): void
    {
        $id          = new AuthorId(1);
        $name        = new Name('some author');
        $articles    = [new ArticleId('article-1')];
        $images      = [new ImageId(1)];
        $languages   = []; // wrong
        $translateEn = new Translate(new LanguageId('en'), new Description('some author 1'));
        $translateUk = new Translate(new LanguageId('uk'), new Description('якийсь автор 1'));
        $translates  = [$translateEn, $translateUk];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param author languages list is empty');

        new Author(
            $id,
            $name,
            true,
            $articles,
            $images,
            $languages,
            $translates
        );
    }

    public function testConstructThrowsErrorOnWrongArticle(): void
    {
        $id          = new AuthorId(1);
        $name        = new Name('some author');
        $articles    = ['wrong'];       // wrong
        $images      = [new ImageId(1)];
        $languages   = [new LanguageId('en'), new LanguageId('uk')];
        $translateEn = new Translate(new LanguageId('en'), new Description('some author 1'));
        $translateUk = new Translate(new LanguageId('uk'), new Description('якийсь автор 1'));
        $translates  = [$translateEn, $translateUk];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param article is not valid');

        new Author(
            $id,
            $name,
            true,
            $articles,
            $images,
            $languages,
            $translates
        );
    }

    public function testConstructThrowsErrorOnWrongImage(): void
    {
        $id          = new AuthorId(1);
        $name        = new Name('some author');
        $articles    = [new ArticleId('article-1')];
        $images      = ['wrong'];           // wrong
        $languages   = [new LanguageId('en'), new LanguageId('uk')];
        $translateEn = new Translate(new LanguageId('en'), new Description('some author 1'));
        $translateUk = new Translate(new LanguageId('uk'), new Description('якийсь автор 1'));
        $translates  = [$translateEn, $translateUk];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param image is not valid');

        new Author(
            $id,
            $name,
            true,
            $articles,
            $images,
            $languages,
            $translates
        );
    }

    public function testConstructThrowsErrorOnWrongTranslate(): void
    {
        $id          = new AuthorId(1);
        $name        = new Name('some author');
        $articles    = [new ArticleId('article-1')];
        $images      = [new ImageId(1)];
        $languages   = [new LanguageId('en'), new LanguageId('uk')];
        $translateEn = 'wrong';     // wrong
        $translateUk = new Translate(new LanguageId('uk'), new Description('якийсь автор 1'));
        $translates  = [$translateEn, $translateUk];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param author translate is invalid');

        new Author(
            $id,
            $name,
            true,
            $articles,
            $images,
            $languages,
            $translates
        );
    }

    public function testConstructThrowsErrorOnWrongTranslateLanguage(): void
    {
        $id          = new AuthorId(1);
        $name        = new Name('some author');
        $articles    = [new ArticleId('article-1')];
        $images      = [new ImageId(1)];
        $languages   = [new LanguageId('en'), new LanguageId('uk')];
        $translateEn = new Translate(new LanguageId('fr'), new Description('abra cadabra'));     // wrong
        $translateUk = new Translate(new LanguageId('uk'), new Description('якийсь автор 1'));
        $translates  = [$translateEn, $translateUk];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Author::INVALID_LANGUAGE);

        new Author(
            $id,
            $name,
            true,
            $articles,
            $images,
            $languages,
            $translates
        );
    }

    public function testCreateWithEmptyTranslates(): void
    {
        $name      = new Name('some author');
        $languages = [new LanguageId('en'), new LanguageId('uk')];

        $model = Author::create($name, $languages);

        $this->assertSame(null, $model->identifier);
        $this->assertSame($name, $model->name);
        $this->assertSame([], $model->getTranslates());
    }

    public function testCreateWithTranslates(): void
    {
        $name        = new Name('some author');
        $languages   = [new LanguageId('en'), new LanguageId('uk')];
        $translateUk = new Translate(new LanguageId('uk'), new Description('якийсь автор 1'));
        $translates  = [$translateUk];

        $model = Author::create($name, $languages, $translates);

        $this->assertSame($translates, $model->getTranslates());
    }

    public function testAddTranslate(): void
    {
        $name        = new Name('some author');
        $languages   = [new LanguageId('en'), new LanguageId('uk')];
        $translateUk = new Translate(new LanguageId('uk'), new Description('якийсь автор 1'));
        $model       = Author::create($name, $languages);

        $model->addTranslate($translateUk);
        $this->assertSame([$translateUk], $model->getTranslates());
    }

    public function testAddTranslateThrowsErrorOnWrongLanguage(): void
    {
        $name        = new Name('some author');
        $languages   = [new LanguageId('en'), new LanguageId('uk')];
        $translateFr = new Translate(new LanguageId('fr'), new Description('article 1'));
        $model       = Author::create($name, $languages);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Author::INVALID_LANGUAGE);

        $model->addTranslate($translateFr);
    }

    public function testActivate(): void
    {
        $id          = new AuthorId(1);
        $name        = new Name('some author');
        $articles    = [new ArticleId('article-1')];
        $images      = [new ImageId(1)];
        $languages   = [new LanguageId('en'), new LanguageId('uk')];
        $translateEn = new Translate(new LanguageId('en'), new Description('some author 1'));
        $translateUk = new Translate(new LanguageId('uk'), new Description('якийсь автор 1'));
        $translates  = [$translateEn, $translateUk];
        $model       = new Author(
            $id,
            $name,
            false,
            $articles,
            $images,
            $languages,
            $translates
        );

        $this->assertSame(false, $model->active);
        $model->activate();
        $this->assertSame(true, $model->active);
    }

    public function testActivateThrowsErrorOnWronId(): void
    {
        $id          = null;
        $name        = new Name('some author');
        $articles    = [new ArticleId('article-1')];
        $images      = [new ImageId(1)];
        $languages   = [new LanguageId('en'), new LanguageId('uk')];
        $translateEn = new Translate(new LanguageId('en'), new Description('some author 1'));
        $translateUk = new Translate(new LanguageId('uk'), new Description('якийсь автор 1'));
        $translates  = [$translateEn, $translateUk];
        $model       = new Author(
            $id,
            $name,
            false,
            $articles,
            $images,
            $languages,
            $translates
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $this->expectExceptionMessage(Author::INVALID_ID);
        $model->activate();
    }

    public function testActivateThrowsErrorOnMissingTranslate(): void
    {
        $id          = new AuthorId(1);
        $name        = new Name('some author');
        $articles    = [new ArticleId('article-1')];
        $images      = [new ImageId(1)];
        $languages   = [new LanguageId('en'), new LanguageId('uk')];
        $translateEn = new Translate(new LanguageId('en'), new Description('some author 1'));
        $translates  = [$translateEn];
        $model       = new Author(
            $id,
            $name,
            false,
            $articles,
            $images,
            $languages,
            $translates
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $this->expectExceptionMessage(Author::MISSING_TRANSLATE);
        $model->activate();
    }

    public function testDeactivate(): void
    {
        $id          = new AuthorId(1);
        $name        = new Name('some author');
        $articles    = [];
        $images      = [];
        $languages   = [new LanguageId('en'), new LanguageId('uk')];
        $translateEn = new Translate(new LanguageId('en'), new Description('some author 1'));
        $translateUk = new Translate(new LanguageId('uk'), new Description('якийсь автор 1'));
        $translates  = [$translateEn, $translateUk];
        $model       = new Author(
            $id,
            $name,
            true,
            $articles,
            $images,
            $languages,
            $translates
        );

        $this->assertSame(true, $model->active);
        $model->deactivate();
        $this->assertSame(false, $model->active);
    }

    public function testDeactivateThrowsErrorOnExistingArticle(): void
    {
        $id          = new AuthorId(1);
        $name        = new Name('some author');
        $articles    = [new ArticleId('article-1')];
        $images      = [];
        $languages   = [new LanguageId('en'), new LanguageId('uk')];
        $translateEn = new Translate(new LanguageId('en'), new Description('some author 1'));
        $translateUk = new Translate(new LanguageId('uk'), new Description('якийсь автор 1'));
        $translates  = [$translateEn, $translateUk];
        $model       = new Author(
            $id,
            $name,
            true,
            $articles,
            $images,
            $languages,
            $translates
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $this->expectExceptionMessage(Author::DEACTIVATE_ARTICLES);
        $model->deactivate();
    }

    public function testDeactivateThrowsErrorOnExistingImage(): void
    {
        $id          = new AuthorId(1);
        $name        = new Name('some author');
        $articles    = [];
        $images      = [new ImageId(1)];
        $languages   = [new LanguageId('en'), new LanguageId('uk')];
        $translateEn = new Translate(new LanguageId('en'), new Description('some author 1'));
        $translateUk = new Translate(new LanguageId('uk'), new Description('якийсь автор 1'));
        $translates  = [$translateEn, $translateUk];
        $model       = new Author(
            $id,
            $name,
            true,
            $articles,
            $images,
            $languages,
            $translates
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $this->expectExceptionMessage(Author::DEACTIVATE_IMAGES);
        $model->deactivate();
    }
}
