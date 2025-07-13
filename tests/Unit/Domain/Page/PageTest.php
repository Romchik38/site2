<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Page;

use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use Romchik38\Site2\Domain\Page\Entities\Translate;
use Romchik38\Site2\Domain\Page\Page;
use Romchik38\Site2\Domain\Page\VO\Description;
use Romchik38\Site2\Domain\Page\VO\Id as PageId;
use Romchik38\Site2\Domain\Page\VO\Name;
use Romchik38\Site2\Domain\Page\VO\ShortDescription;

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

        $page = new Page($id, true, $languages, $translates);

        $this->assertSame($id, $page->id);
        $this->assertSame($translateEn, $page->getTranslate('en'));
        $this->assertSame($translateUk, $page->getTranslate('uk'));
        $this->assertSame($translates, $page->getTranslates());
    }
}
