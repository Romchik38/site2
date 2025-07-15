<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Page;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use Romchik38\Site2\Domain\Page\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\Page\Entities\Translate;
use Romchik38\Site2\Domain\Page\Page;
use Romchik38\Site2\Domain\Page\VO\Description;
use Romchik38\Site2\Domain\Page\VO\Id as PageId;
use Romchik38\Site2\Domain\Page\VO\Name;
use Romchik38\Site2\Domain\Page\VO\ShortDescription;
use Romchik38\Site2\Domain\Page\VO\Url;

final class PageTest extends TestCase
{
    /**
     * Also tested:
     *   getTranslate
     *   getTranslates
     */
    public function testConstruct(): void
    {
        $id        = new PageId(1);
        $url       = new Url('some-url');
        $languages = [new LanguageId('en'), new LanguageId('uk')];

        $nameEn             = new Name('Some page name');
        $shortDescriptionEn = new ShortDescription('Some short description');
        $descriptionEn      = new Description('Some description');
        $translateEn        = new Translate(
            new LanguageId('en'),
            $nameEn,
            $shortDescriptionEn,
            $descriptionEn
        );
        $nameUk             = new Name('Опис якоїсь сторінки');
        $shortDescriptionUk = new ShortDescription('Якийсь короткий опис');
        $descriptionUk      = new Description('Якийсь опис');
        $translateUk        = new Translate(
            new LanguageId('uk'),
            $nameUk,
            $shortDescriptionUk,
            $descriptionUk
        );
        $translates         = [$translateEn, $translateUk];

        $page = new Page($id, true, $url, $languages, $translates);

        $this->assertSame($id, $page->id);
        $this->assertSame($translateEn, $page->getTranslate('en'));
        $this->assertSame($translateUk, $page->getTranslate('uk'));
        $this->assertSame($translates, $page->getTranslates());
    }

    public function testConstructThrowsErrorOnWrongLanguage(): void
    {
        $id        = new PageId(1);
        $url       = new Url('some-url');
        $languages = ['wrong', new LanguageId('uk')];       // wrong

        $nameEn             = new Name('Some page name');
        $shortDescriptionEn = new ShortDescription('Some short description');
        $descriptionEn      = new Description('Some description');
        $translateEn        = new Translate(
            new LanguageId('en'),
            $nameEn,
            $shortDescriptionEn,
            $descriptionEn
        );
        $nameUk             = new Name('Опис якоїсь сторінки');
        $shortDescriptionUk = new ShortDescription('Якийсь короткий опис');
        $descriptionUk      = new Description('Якийсь опис');
        $translateUk        = new Translate(
            new LanguageId('uk'),
            $nameUk,
            $shortDescriptionUk,
            $descriptionUk
        );
        $translates         = [$translateEn, $translateUk];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param page language id is invalid');
        new Page($id, true, $url, $languages, $translates);
    }

    public function testConstructThrowsErrorOnWrongTranslate(): void
    {
        $id        = new PageId(1);
        $url       = new Url('some-url');
        $languages = [new LanguageId('en'), new LanguageId('uk')];

        $translateEn        = 'wrong translate';            // wrong
        $nameUk             = new Name('Опис якоїсь сторінки');
        $shortDescriptionUk = new ShortDescription('Якийсь короткий опис');
        $descriptionUk      = new Description('Якийсь опис');
        $translateUk        = new Translate(
            new LanguageId('uk'),
            $nameUk,
            $shortDescriptionUk,
            $descriptionUk
        );
        $translates         = [$translateEn, $translateUk];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param page translate is invalid');
        new Page($id, true, $url, $languages, $translates);
    }

    public function testConstructThrowsErrorOnMissingTranslate(): void
    {
        $id        = new PageId(1);
        $url       = new Url('some-url');
        $languages = [new LanguageId('en'), new LanguageId('uk')];

        $nameUk             = new Name('Опис якоїсь сторінки');
        $shortDescriptionUk = new ShortDescription('Якийсь короткий опис');
        $descriptionUk      = new Description('Якийсь опис');
        $translateUk        = new Translate(
            new LanguageId('uk'),
            $nameUk,
            $shortDescriptionUk,
            $descriptionUk
        );
        $translates         = [$translateUk];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Page has missing translates');
        new Page($id, true, $url, $languages, $translates);
    }

    public function testConstructThrowsErrorOnNonExpectingTranslateLanguage(): void
    {
        $id        = new PageId(1);
        $url       = new Url('some-url');
        $languages = [new LanguageId('fr'), new LanguageId('uk')];

        $nameEn             = new Name('Some page name');
        $shortDescriptionEn = new ShortDescription('Some short description');
        $descriptionEn      = new Description('Some description');
        $translateEn        = new Translate(
            new LanguageId('en'),
            $nameEn,
            $shortDescriptionEn,
            $descriptionEn
        );
        $nameUk             = new Name('Опис якоїсь сторінки');
        $shortDescriptionUk = new ShortDescription('Якийсь короткий опис');
        $descriptionUk      = new Description('Якийсь опис');
        $translateUk        = new Translate(
            new LanguageId('uk'),
            $nameUk,
            $shortDescriptionUk,
            $descriptionUk
        );
        $translates         = [$translateEn, $translateUk];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param page translate language has non expected language');
        new Page($id, false, $url, $languages, $translates);
    }

    public function testActivate(): void
    {
        $id        = new PageId(1);
        $url       = new Url('some-url');
        $languages = [new LanguageId('en'), new LanguageId('uk')];

        $nameEn             = new Name('Some page name');
        $shortDescriptionEn = new ShortDescription('Some short description');
        $descriptionEn      = new Description('Some description');
        $translateEn        = new Translate(
            new LanguageId('en'),
            $nameEn,
            $shortDescriptionEn,
            $descriptionEn
        );
        $nameUk             = new Name('Опис якоїсь сторінки');
        $shortDescriptionUk = new ShortDescription('Якийсь короткий опис');
        $descriptionUk      = new Description('Якийсь опис');
        $translateUk        = new Translate(
            new LanguageId('uk'),
            $nameUk,
            $shortDescriptionUk,
            $descriptionUk
        );
        $translates         = [$translateEn, $translateUk];

        $page = new Page($id, false, $url, $languages, $translates);
        $this->assertSame(false, $page->active);
        $page->activate();
        $this->assertSame(true, $page->active);
    }

    public function testActivateThrowsErrorOnMissingTranslate(): void
    {
        $id        = new PageId(1);
        $url       = new Url('some-url');
        $languages = [new LanguageId('en'), new LanguageId('uk')];

        $nameUk             = new Name('Опис якоїсь сторінки');
        $shortDescriptionUk = new ShortDescription('Якийсь короткий опис');
        $descriptionUk      = new Description('Якийсь опис');
        $translateUk        = new Translate(
            new LanguageId('uk'),
            $nameUk,
            $shortDescriptionUk,
            $descriptionUk
        );
        $translates         = [$translateUk];

        $page = new Page($id, false, $url, $languages, $translates);

        $this->expectException(CouldNotChangeActivityException::class);
        $this->expectExceptionMessage('Page has missing translates');
        $page->activate();
    }

    /** Could not test for wrong translation due to the fact that there is no way
     * to bring the model into such a test state.
     * Both __construct and addTranslate will catch this
     *
     * public function testActivateThrowsErrorOnWrongTranslate(): void {}
     **/
    public function testAddTranslate(): void
    {
        $id        = new PageId(1);
        $url       = new Url('some-url');
        $languages = [new LanguageId('en'), new LanguageId('uk')];

        $nameEn             = new Name('Some page name');
        $shortDescriptionEn = new ShortDescription('Some short description');
        $descriptionEn      = new Description('Some description');
        $translateEn        = new Translate(
            new LanguageId('en'),
            $nameEn,
            $shortDescriptionEn,
            $descriptionEn
        );
        $nameUk             = new Name('Опис якоїсь сторінки');
        $shortDescriptionUk = new ShortDescription('Якийсь короткий опис');
        $descriptionUk      = new Description('Якийсь опис');
        $translateUk        = new Translate(
            new LanguageId('uk'),
            $nameUk,
            $shortDescriptionUk,
            $descriptionUk
        );
        $translates         = [$translateUk];

        $page = new Page($id, false, $url, $languages, $translates);

        $page->addTranslate($translateEn);
        $this->assertSame($translateEn, $page->getTranslate('en'));
    }

    public function testAddTranslateThrowsErrorOnWrongLanguage(): void
    {
        $id        = new PageId(1);
        $url       = new Url('some-url');
        $languages = [new LanguageId('fr'), new LanguageId('uk')];

        $nameEn             = new Name('Some page name');
        $shortDescriptionEn = new ShortDescription('Some short description');
        $descriptionEn      = new Description('Some description');
        $translateEn        = new Translate(
            new LanguageId('en'),
            $nameEn,
            $shortDescriptionEn,
            $descriptionEn
        );
        $nameUk             = new Name('Опис якоїсь сторінки');
        $shortDescriptionUk = new ShortDescription('Якийсь короткий опис');
        $descriptionUk      = new Description('Якийсь опис');
        $translateUk        = new Translate(
            new LanguageId('uk'),
            $nameUk,
            $shortDescriptionUk,
            $descriptionUk
        );
        $translates         = [$translateUk];

        $page = new Page($id, false, $url, $languages, $translates);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param page translate language has non expected language');
        $page->addTranslate($translateEn);
    }

    public function testDeactivate(): void
    {
        $id        = new PageId(1);
        $url       = new Url('some-url');
        $languages = [new LanguageId('en'), new LanguageId('uk')];

        $nameEn             = new Name('Some page name');
        $shortDescriptionEn = new ShortDescription('Some short description');
        $descriptionEn      = new Description('Some description');
        $translateEn        = new Translate(
            new LanguageId('en'),
            $nameEn,
            $shortDescriptionEn,
            $descriptionEn
        );
        $nameUk             = new Name('Опис якоїсь сторінки');
        $shortDescriptionUk = new ShortDescription('Якийсь короткий опис');
        $descriptionUk      = new Description('Якийсь опис');
        $translateUk        = new Translate(
            new LanguageId('uk'),
            $nameUk,
            $shortDescriptionUk,
            $descriptionUk
        );
        $translates         = [$translateEn, $translateUk];

        $page = new Page($id, true, $url, $languages, $translates);
        $this->assertSame(true, $page->active);
        $page->deactivate();
        $this->assertSame(false, $page->active);
    }
}
