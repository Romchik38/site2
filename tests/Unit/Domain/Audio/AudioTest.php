<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Audio;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Article\VO\ArticleId;
use Romchik38\Site2\Domain\Audio\Audio;
use Romchik38\Site2\Domain\Audio\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\Audio\CouldNotDeleteTranslateException;
use Romchik38\Site2\Domain\Audio\Entities\Article;
use Romchik38\Site2\Domain\Audio\Entities\Content;
use Romchik38\Site2\Domain\Audio\Entities\Translate;
use Romchik38\Site2\Domain\Audio\VO\Description;
use Romchik38\Site2\Domain\Audio\VO\Id;
use Romchik38\Site2\Domain\Audio\VO\Name;
use Romchik38\Site2\Domain\Audio\VO\Path;
use Romchik38\Site2\Domain\Audio\VO\Size;
use Romchik38\Site2\Domain\Audio\VO\Type;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use stdClass;

use function count;

final class AudioTest extends TestCase
{
    /**
     * Tested:
     *   create
     *   getId
     *   getName
     *   getTranslate
     *   getTranslates
     *   getArticles
     */
    public function testCreate(): void
    {
        $name = new Name('audio-name-1');

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(
                new LanguageId('en'),
                new Description('Some audio track'),
                new Path('some/file-en-1.mp3')
            ),
            new Translate(
                new LanguageId('uk'),
                new Description('Якийсь аудіо трек'),
                new Path('some/file-uk-1.mp3')
            ),
        ];
        $audio      = Audio::create(
            $name,
            $languages,
            $translates
        );

        $this->assertSame(null, $audio->getId());
        $this->assertSame('audio-name-1', (string) $audio->getName());

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
        $name = new Name('audio-name-1');

        $languages  = [1, 3];
        $translates = [
            new Translate(
                new LanguageId('en'),
                new Description('Some audio track'),
                new Path('some/file-en-1.mp3')
            ),
            new Translate(
                new LanguageId('uk'),
                new Description('Якийсь аудіо трек'),
                new Path('some/file-uk-1.mp3')
            ),
        ];

        $this->expectException(InvalidArgumentException::class);

        Audio::create(
            $name,
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
        $name = new Name('audio-name-1');

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(
                new LanguageId('fr'),
                new Description('Some audio track'),
                new Path('/some/file-fr-1.mp3')
            ), // Invalid language
            new Translate(
                new LanguageId('uk'),
                new Description('Якийсь аудіо трек'),
                new Path('some/file-uk-1.mp3')
            ),
        ];

        $this->expectException(InvalidArgumentException::class);

        Audio::create(
            $name,
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
        $name = new Name('audio-name-1');

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new stdClass(), // Invalid Translate instance
            new Translate(
                new LanguageId('uk'),
                new Description('Якийсь аудіо трек'),
                new Path('some/file-uk-1.mp3')
            ),
        ];

        $this->expectException(InvalidArgumentException::class);

        Audio::create(
            $name,
            $languages,
            $translates
        );
    }

    public function testReName(): void
    {
        $name = new Name('audio-name-1');

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(
                new LanguageId('en'),
                new Description('Some audio track'),
                new Path('some/file-en-1.mp3')
            ),
            new Translate(
                new LanguageId('uk'),
                new Description('Якийсь аудіо трек'),
                new Path('some/file-uk-1.mp3')
            ),
        ];
        $audio      = Audio::create(
            $name,
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
     *   getArticles
     *   getTranslates
     */
    public function testLoad(): void
    {
        $id   = new Id(1);
        $name = new Name('audio-name-1');

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(
                new LanguageId('en'),
                new Description('Some audio track'),
                new Path('some/file-en-1.mp3')
            ),
            new Translate(
                new LanguageId('uk'),
                new Description('Якийсь аудіо трек'),
                new Path('some/file-uk-1.mp3')
            ),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), true),
        ];

        $audio = Audio::load(
            $id,
            true,
            $name,
            $articles,
            $languages,
            $translates
        );

        $t1 = $audio->getTranslate('en');
        $t2 = $audio->getTranslate('uk');

        $this->assertSame($id, $audio->getId());
        $this->assertSame(true, $audio->isActive());
        $this->assertSame($name, $audio->getName());
        $this->assertSame($articles, $audio->getArticles());
        $this->assertSame(2, count($audio->getTranslates()));
        $this->assertSame('Some audio track', (string) $t1->getDescription());
        $this->assertSame('Якийсь аудіо трек', (string) $t2->getDescription());
    }

    public function testLoadActiveArticleAndNotActiveImage(): void
    {
        $id   = new Id(1);
        $name = new Name('audio-name-1');

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(
                new LanguageId('en'),
                new Description('Some audio track'),
                new Path('some/file-en-1.mp3')
            ),
            new Translate(
                new LanguageId('uk'),
                new Description('Якийсь аудіо трек'),
                new Path('some/file-uk-1.mp3')
            ),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), true), // wrong
        ];

        $this->expectException(InvalidArgumentException::class);

        Audio::load(
            $id,
            false, // wrong
            $name,
            $articles,
            $languages,
            $translates
        );
    }

    public function testLoadThrowsErrorInvalidArticle(): void
    {
        $id   = new Id(1);
        $name = new Name('audio-name-1');

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(
                new LanguageId('en'),
                new Description('Some audio track'),
                new Path('some/file-en-1.mp3')
            ),
            new Translate(
                new LanguageId('uk'),
                new Description('Якийсь аудіо трек'),
                new Path('some/file-uk-1.mp3')
            ),
        ];

        $articles = [
            'some string', // wrong
        ];

        $this->expectException(InvalidArgumentException::class);

        Audio::load(
            $id,
            false,
            $name,
            $articles,
            $languages,
            $translates
        );
    }

    public function testActivate(): void
    {
        $id   = new Id(1);
        $name = new Name('audio-name-1');

        $languages   = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translateEn = new Translate(
            new LanguageId('en'),
            new Description('Some audio track'),
            new Path('some/file-en-1.mp3')
        );
        $translateUk = new Translate(
            new LanguageId('uk'),
            new Description('Якийсь аудіо трек'),
            new Path('some/file-uk-1.mp3')
        );

        $translateEn->loadContent(new Content(
            '\x1\x00\xa1',
            new Type('mp3'),
            new Size(35200)
        ));

        $translateUk->loadContent(new Content(
            '\x1\x20\xc4',
            new Type('mp3'),
            new Size(31010)
        ));

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];

        $audio = Audio::load(
            $id,
            false,
            $name,
            $articles,
            $languages,
            [$translateEn, $translateUk]
        );

        $audio->activate();
        $this->assertSame(true, $audio->isActive());
    }

    public function testActivateThrowsErrorOnMissingTranslate(): void
    {
        $id   = new Id(1);
        $name = new Name('audio-name-1');

        $languages = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];

        $translateEn = new Translate(
            new LanguageId('en'),
            new Description('Some audio track'),
            new Path('some/file-en-1.mp3')
        );

        $translateEn->loadContent(new Content(
            '\x1\x00\xa1',
            new Type('mp3'),
            new Size(35200)
        ));

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];

        $audio = Audio::load(
            $id,
            false,
            $name,
            $articles,
            $languages,
            [$translateEn]
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $audio->activate();
    }

    public function testActivateThrowsErrorOnCreate(): void
    {
        $name = new Name('audio-name-1');

        $languages   = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translateEn = new Translate(
            new LanguageId('en'),
            new Description('Some audio track'),
            new Path('some/file-en-1.mp3')
        );
        $translateUk = new Translate(
            new LanguageId('uk'),
            new Description('Якийсь аудіо трек'),
            new Path('some/file-uk-1.mp3')
        );

        $translateEn->loadContent(new Content(
            '\x1\x00\xa1',
            new Type('mp3'),
            new Size(35200)
        ));

        $translateUk->loadContent(new Content(
            '\x1\x20\xc4',
            new Type('mp3'),
            new Size(31010)
        ));

        $audio = Audio::create(
            $name,
            $languages,
            [$translateEn, $translateUk]
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $audio->activate();
    }

    public function testActivateThrowsErrorContentNotLoaded(): void
    {
        $id   = new Id(1);
        $name = new Name('audio-name-1');

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(
                new LanguageId('en'),
                new Description('Some audio track'),
                new Path('some/file-en-1.mp3')
            ),
            new Translate(
                new LanguageId('uk'),
                new Description('Some audio track'),
                new Path('some/file-uk-1.mp3')
            ),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];

        $audio = Audio::load(
            $id,
            false,
            $name,
            $articles,
            $languages,
            $translates
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $audio->activate();
    }

    public function testAddTranslateWithNonExistingLanguage(): void
    {
        $id   = new Id(1);
        $name = new Name('audio-name-1');

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(
                new LanguageId('en'),
                new Description('Some audio track'),
                new Path('some/file-en-1.mp3')
            ),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];

        $audio = Audio::load(
            $id,
            false,
            $name,
            $articles,
            $languages,
            $translates
        );

        $addedTranslate = new Translate(
            new LanguageId('uk'),
            new Description('Якийсь аудіо трек'),
            new Path('some/file-uk-1.mp3')
        );
        $audio->addTranslate($addedTranslate);
        $this->assertSame($addedTranslate, $audio->getTranslate('uk'));
    }

    public function testAddTranslateRewriteExisting(): void
    {
        $id   = new Id(1);
        $name = new Name('audio-name-1');

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(
                new LanguageId('en'),
                new Description('Some audio track'),
                new Path('some/file-en-1.mp3')
            ),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];

        $audio = Audio::load(
            $id,
            false,
            $name,
            $articles,
            $languages,
            $translates
        );

        $rewritedTranslate = new Translate(
            new LanguageId('en'),
            new Description('Some audio track 1'),
            new Path('some/file-en-1.mp3')
        );
        $audio->addTranslate($rewritedTranslate);
        $this->assertSame($rewritedTranslate, $audio->getTranslate('en'));
    }

    public function testAddTranslateThrowsErrorOnWrongLanguage(): void
    {
        $id   = new Id(1);
        $name = new Name('audio-name-1');

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(
                new LanguageId('en'),
                new Description('Some audio track'),
                new Path('some/file-en-1.mp3')
            ),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];

        $audio = Audio::load(
            $id,
            false,
            $name,
            $articles,
            $languages,
            $translates
        );

        $addedTranslate = new Translate(
            new LanguageId('fr'),
            new Description('Якийсь аудіо трек'),
            new Path('some/file-fr-1.mp3')
        );

        $this->expectException(InvalidArgumentException::class);
        $audio->addTranslate($addedTranslate);
    }

    public function testDeactivate(): void
    {
        $id   = new Id(1);
        $name = new Name('audio-name-1');

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(
                new LanguageId('en'),
                new Description('Some audio track'),
                new Path('some/file-en-1.mp3')
            ),
            new Translate(
                new LanguageId('uk'),
                new Description('Якийсь аудіо трек'),
                new Path('some/file-uk-1.mp3')
            ),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), false),
        ];

        $audio = Audio::load(
            $id,
            true,
            $name,
            $articles,
            $languages,
            $translates
        );

        $audio->deactivate();
        $this->assertSame(false, $audio->isActive());
    }

    public function testDeactivateThrowsErrorOnExistingActiveArticle(): void
    {
        $id   = new Id(1);
        $name = new Name('audio-name-1');

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(
                new LanguageId('en'),
                new Description('Some audio track'),
                new Path('some/file-en-1.mp3')
            ),
            new Translate(
                new LanguageId('uk'),
                new Description('Якийсь аудіо трек'),
                new Path('some/file-uk-1.mp3')
            ),
        ];

        $articles = [
            new Article(new ArticleId('article-1'), true),
        ];

        $audio = Audio::load(
            $id,
            true,
            $name,
            $articles,
            $languages,
            $translates
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $audio->deactivate();
    }

    public function testDeleteTranslate(): void
    {
        $id   = new Id(1);
        $name = new Name('audio-name-1');

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(
                new LanguageId('en'),
                new Description('Some audio track'),
                new Path('some/file-en-1.mp3')
            ),
            new Translate(
                new LanguageId('uk'),
                new Description('Якийсь аудіо трек'),
                new Path('some/file-uk-1.mp3')
            ),
        ];

        $audio = Audio::load(
            $id,
            false,
            $name,
            [],
            $languages,
            $translates
        );

        $audio->deleteTranslate('en');
        $this->assertSame(null, $audio->getTranslate('en'));

        $tUk = $audio->getTranslate('uk');
        $this->assertSame('Якийсь аудіо трек', (string) $tUk->getDescription());
    }

    public function testDeleteTranslateThrowsError(): void
    {
        $id   = new Id(1);
        $name = new Name('audio-name-1');

        $languages  = [
            new LanguageId('en'),
            new LanguageId('uk'),
        ];
        $translates = [
            new Translate(
                new LanguageId('en'),
                new Description('Some audio track'),
                new Path('some/file-en-1.mp3')
            ),
            new Translate(
                new LanguageId('uk'),
                new Description('Якийсь аудіо трек'),
                new Path('some/file-uk-1.mp3')
            ),
        ];

        $audio = Audio::load(
            $id,
            true,
            $name,
            [],
            $languages,
            $translates
        );

        $this->expectException(CouldNotDeleteTranslateException::class);
        $audio->deleteTranslate('en');
    }
}
