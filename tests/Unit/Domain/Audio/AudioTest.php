<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Audio;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Article\VO\ArticleId;
use Romchik38\Site2\Domain\Audio\Audio;
use Romchik38\Site2\Domain\Audio\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\Audio\Entities\Article;
use Romchik38\Site2\Domain\Audio\Entities\Author;
use Romchik38\Site2\Domain\Audio\Entities\Content;
use Romchik38\Site2\Domain\Audio\Entities\Translate;
use Romchik38\Site2\Domain\Audio\VO\Description;
use Romchik38\Site2\Domain\Audio\VO\Id;
use Romchik38\Site2\Domain\Audio\VO\Name;
use Romchik38\Site2\Domain\Audio\VO\Size;
use Romchik38\Site2\Domain\Audio\VO\Type;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use stdClass;

use function count;

final class AudioTest extends TestCase
{
    /**
     * Tested:
     *   create
     *   getAuthor
     *   getId
     *   getName
     *   getTranslate
     *   getTranslates
     *   getArticles
     */
    public function testCreate(): void
    {
        $name   = new Name('audio-name-1');
        $author = new Author(
            new AuthorId('25'),
            true
        );

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Some audio track')),
            new Translate(new LanguageId('uk'), new Description('Якийсь аудіо трек')),
        ];
        $audio      = Audio::create(
            $name,
            $author,
            $languages,
            $translates
        );

        $this->assertSame(null, $audio->getId());
        $this->assertSame('audio-name-1', (string) $audio->getName());
        $this->assertSame($author, $audio->getAuthor());

        $translates = $audio->getTranslates();
        $this->assertSame(2, count($translates));
        $t1 = $audio->getTranslate('en');
        $t2 = $audio->getTranslate('uk');
        $this->assertSame('en', (string) $t1->getLanguage());
        $this->assertSame('Some audio track', (string) $t1->getDescription());
        $this->assertSame('uk', (string) $t2->getLanguage());
        $this->assertSame('Якийсь аудіо трек', (string) $t2->getDescription());
        $this->assertSame([], $audio->getArticles());
    }

     /**
      * Tested:
      *   __construct
      */
    public function testCreateThrowsErrorInvalidLanguages(): void
    {
        $name   = new Name('audio-name-1');
        $author = new Author(
            new AuthorId('25'),
            true
        );

        $languages  = [1, 3];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Some audio track')),
            new Translate(new LanguageId('uk'), new Description('Якийсь аудіо трек')),
        ];

        $this->expectException(InvalidArgumentException::class);

        Audio::create(
            $name,
            $author,
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
        $name   = new Name('audio-name-1');
        $author = new Author(
            new AuthorId('25'),
            true
        );

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('fr'), new Description('Some audio track')), // Invalid language
            new Translate(new LanguageId('uk'), new Description('Якийсь аудіо трек')),
        ];

        $this->expectException(InvalidArgumentException::class);

        Audio::create(
            $name,
            $author,
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
        $name   = new Name('audio-name-1');
        $author = new Author(
            new AuthorId('25'),
            true
        );

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new stdClass(), // Invalid Translate instance
            new Translate(new LanguageId('uk'), new Description('Якийсь аудіо трек')),
        ];

        $this->expectException(InvalidArgumentException::class);

        Audio::create(
            $name,
            $author,
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
        $name   = new Name('audio-name-1');
        $author = new Author(
            new AuthorId('25'),
            true
        );

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Some audio track')),
            new Translate(new LanguageId('uk'), new Description('Якийсь аудіо трек')),
        ];

        $audio = Audio::create(
            $name,
            $author,
            $languages,
            $translates
        );

        $data    = '\x\x1a\x00';
        $content = new Content(
            $data,
            new Type('mp3'),
            new Size(35200)
        );
        $audio->loadContent($content);

        $this->assertSame($content, $audio->getContent());
    }

    public function testGetContentReturnNull(): void
    {
        $name   = new Name('audio-name-1');
        $author = new Author(
            new AuthorId('25'),
            true
        );

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Some audio track')),
            new Translate(new LanguageId('uk'), new Description('Якийсь аудіо трек')),
        ];

        $audio = Audio::create(
            $name,
            $author,
            $languages,
            $translates
        );

        $this->assertSame(null, $audio->getContent());
    }

    public function testReName(): void
    {
        $name   = new Name('audio-name-1');
        $author = new Author(
            new AuthorId('25'),
            true
        );

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Some audio track')),
            new Translate(new LanguageId('uk'), new Description('Якийсь аудіо трек')),
        ];
        $audio      = Audio::create(
            $name,
            $author,
            $languages,
            $translates
        );

        $newName = new Name('audio-name-2');
        $audio->reName($newName);
        $this->assertSame($newName, $audio->getName());
    }

    /**
     * Tests
     *   __constract
     *   getId
     *   isActive
     *   getName
     *   getAuthor
     *   getArticles
     *   getTranslates
     */
    public function testLoad(): void
    {
        $id     = new Id(1);
        $name   = new Name('audio-name-1');
        $author = new Author(
            new AuthorId('25'),
            true
        );

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Some audio track')),
            new Translate(new LanguageId('uk'), new Description('Якийсь аудіо трек')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), true),
        ];

        $audio = Audio::load(
            $id,
            true,
            $name,
            $author,
            $articles,
            $languages,
            $translates
        );

        $t1 = $audio->getTranslate('en');
        $t2 = $audio->getTranslate('uk');

        $this->assertSame($id, $audio->getId());
        $this->assertSame(true, $audio->isActive());
        $this->assertSame($name, $audio->getName());
        $this->assertSame($author, $audio->getAuthor());
        $this->assertSame($articles, $audio->getArticles());
        $this->assertSame(2, count($audio->getTranslates()));
        $this->assertSame('Some audio track', (string) $t1->getDescription());
        $this->assertSame('Якийсь аудіо трек', (string) $t2->getDescription());
    }

    public function testLoadActiveArticleAndNotActiveImage(): void
    {
        $id     = new Id(1);
        $name   = new Name('audio-name-1');
        $author = new Author(
            new AuthorId('25'),
            true
        );

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Some audio track')),
            new Translate(new LanguageId('uk'), new Description('Якийсь аудіо трек')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), true), // wrong
        ];

        $this->expectException(InvalidArgumentException::class);

        Audio::load(
            $id,
            false, // wrong
            $name,
            $author,
            $articles,
            $languages,
            $translates
        );
    }

    public function testLoadThrowsErrorInvalidArticle(): void
    {
        $id     = new Id(1);
        $name   = new Name('audio-name-1');
        $author = new Author(
            new AuthorId('25'),
            true
        );

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Some audio track')),
            new Translate(new LanguageId('uk'), new Description('Якийсь аудіо трек')),
        ];

        $articles = [
            'some string', // wrong
        ];

        $this->expectException(InvalidArgumentException::class);

        Audio::load(
            $id,
            false,
            $name,
            $author,
            $articles,
            $languages,
            $translates
        );
    }

    public function testActivate(): void
    {
        $id     = new Id(1);
        $name   = new Name('audio-name-1');
        $author = new Author(
            new AuthorId('25'),
            true
        );

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Some audio track')),
            new Translate(new LanguageId('uk'), new Description('Якийсь аудіо трек')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];

        $audio = Audio::load(
            $id,
            false,
            $name,
            $author,
            $articles,
            $languages,
            $translates
        );

        $data    = '\x1\x00\xa1';
        $content = new Content(
            $data,
            new Type('mp3'),
            new Size(35200)
        );
        $audio->loadContent($content);

        $audio->activate();
        $this->assertSame(true, $audio->isActive());
    }

    public function testActivateThrowsErrorOnMissingTranslate(): void
    {
        $id     = new Id(1);
        $name   = new Name('audio-name-1');
        $author = new Author(
            new AuthorId('25'),
            true
        );

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Some audio track')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];

        $audio = Audio::load(
            $id,
            false,
            $name,
            $author,
            $articles,
            $languages,
            $translates
        );

        $data    = '\x1\x00\xa1';
        $content = new Content(
            $data,
            new Type('mp3'),
            new Size(35200)
        );
        $audio->loadContent($content);

        $this->expectException(CouldNotChangeActivityException::class);
        $audio->activate();
    }

    public function testActivateThrowsErrorOnCreate(): void
    {
        $name   = new Name('audio-name-1');
        $author = new Author(
            new AuthorId('25'),
            true
        );

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Some audio track')),
            new Translate(new LanguageId('uk'), new Description('Якийсь аудіо трек')),
        ];
        $audio      = Audio::create(
            $name,
            $author,
            $languages,
            $translates
        );

        $data    = '\x1\x00\xa1';
        $content = new Content(
            $data,
            new Type('mp3'),
            new Size(35200)
        );
        $audio->loadContent($content);

        $this->expectException(CouldNotChangeActivityException::class);
        $audio->activate();
    }

    public function testActivateThrowsErrorImageNotLoaded(): void
    {
        $id     = new Id(1);
        $name   = new Name('audio-name-1');
        $author = new Author(
            new AuthorId('25'),
            true
        );

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Some audio track')),
            new Translate(new LanguageId('uk'), new Description('Some audio track')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];

        $audio = Audio::load(
            $id,
            false,
            $name,
            $author,
            $articles,
            $languages,
            $translates
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $audio->activate();
    }

    public function testActivateThrowsErrorAuthorNotActive(): void
    {
        $id     = new Id(1);
        $name   = new Name('audio-name-1');
        $author = new Author(
            new AuthorId('25'),
            false
        );

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Some audio track')),
            new Translate(new LanguageId('uk'), new Description('Some audio track')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];

        $audio = Audio::load(
            $id,
            false,
            $name,
            $author,
            $articles,
            $languages,
            $translates
        );

        $data    = '\x1\x00\xa1';
        $content = new Content(
            $data,
            new Type('mp3'),
            new Size(35200)
        );
        $audio->loadContent($content);

        $this->expectException(CouldNotChangeActivityException::class);
        $audio->activate();
    }

    public function testAddTranslateWithNonExistingLanguage(): void
    {
        $id     = new Id(1);
        $name   = new Name('audio-name-1');
        $author = new Author(
            new AuthorId('25'),
            true
        );

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Some audio track')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];

        $audio = Audio::load(
            $id,
            false,
            $name,
            $author,
            $articles,
            $languages,
            $translates
        );

        $addedTranslate = new Translate(new LanguageId('uk'), new Description('Якийсь аудіо трек'));
        $audio->addTranslate($addedTranslate);
        $this->assertSame($addedTranslate, $audio->getTranslate('uk'));
    }

    public function testAddTranslateRewriteExisting(): void
    {
        $id     = new Id(1);
        $name   = new Name('audio-name-1');
        $author = new Author(
            new AuthorId('25'),
            true
        );

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Some audio track')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];

        $audio = Audio::load(
            $id,
            false,
            $name,
            $author,
            $articles,
            $languages,
            $translates
        );

        $rewritedTranslate = new Translate(new LanguageId('en'), new Description('Some audio track 1'));
        $audio->addTranslate($rewritedTranslate);
        $this->assertSame($rewritedTranslate, $audio->getTranslate('en'));
    }

    public function testAddTranslateThrowsErrorOnWrongLanguage(): void
    {
        $id     = new Id(1);
        $name   = new Name('audio-name-1');
        $author = new Author(
            new AuthorId('25'),
            true
        );

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Some audio track')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];

        $audio = Audio::load(
            $id,
            false,
            $name,
            $author,
            $articles,
            $languages,
            $translates
        );

        $addedTranslate = new Translate(new LanguageId('fr'), new Description('Якийсь аудіо трек'));

        $this->expectException(InvalidArgumentException::class);
        $audio->addTranslate($addedTranslate);
    }

    public function testDeactivate(): void
    {
        $id     = new Id(1);
        $name   = new Name('audio-name-1');
        $author = new Author(
            new AuthorId('25'),
            true
        );

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Some audio track')),
            new Translate(new LanguageId('uk'), new Description('Якийсь аудіо трек')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];

        $audio = Audio::load(
            $id,
            true,
            $name,
            $author,
            $articles,
            $languages,
            $translates
        );

        $audio->deactivate();
        $this->assertSame(false, $audio->isActive());
    }

    public function testDeactivateThrowsErrorOnExistingActiveArticle(): void
    {
        $id     = new Id(1);
        $name   = new Name('audio-name-1');
        $author = new Author(
            new AuthorId('25'),
            true
        );

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Some audio track')),
            new Translate(new LanguageId('uk'), new Description('Якийсь аудіо трек')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), true),
        ];

        $audio = Audio::load(
            $id,
            true,
            $name,
            $author,
            $articles,
            $languages,
            $translates
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $audio->deactivate();
    }

    public function testChangeAuthorWhenActive(): void
    {
        $id     = new Id(1);
        $name   = new Name('audio-name-1');
        $author = new Author(
            new AuthorId('25'),
            true
        );

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Some audio track')),
            new Translate(new LanguageId('uk'), new Description('Якийсь аудіо трек')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];

        $audio = Audio::load(
            $id,
            true,
            $name,
            $author,
            $articles,
            $languages,
            $translates
        );

        // 1. Success
        $newAuthor = new Author(
            new AuthorId('26'),
            true
        );
        $audio->changeAuthor($newAuthor);
        $this->assertSame($newAuthor, $audio->getAuthor());

        // 2. Exception
        $newAuthor2 = new Author(
            new AuthorId('27'),
            false
        );
        $this->expectException(InvalidArgumentException::class);
        $audio->changeAuthor($newAuthor2);
    }

    public function testChangeAuthorWhenNonActive(): void
    {
        $id     = new Id(1);
        $name   = new Name('audio-name-1');
        $author = new Author(
            new AuthorId('25'),
            true
        );

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(new LanguageId('en'), new Description('Some audio track')),
            new Translate(new LanguageId('uk'), new Description('Якийсь аудіо трек')),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];

        $audio = Audio::load(
            $id,
            false,
            $name,
            $author,
            $articles,
            $languages,
            $translates
        );

        // 1. Success
        $newAuthor = new Author(
            new AuthorId('26'),
            true
        );
        $audio->changeAuthor($newAuthor);
        $this->assertSame($newAuthor, $audio->getAuthor());

        // 2. Also success
        $newAuthor2 = new Author(
            new AuthorId('27'),
            false
        );
        $audio->changeAuthor($newAuthor2);
        $this->assertSame($newAuthor2, $audio->getAuthor());
    }
}
