<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Image;

use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Image\Entities\Translate;
use Romchik38\Site2\Domain\Image\Image;
use Romchik38\Site2\Domain\Image\VO\Description;
use Romchik38\Site2\Domain\Image\VO\Name;
use Romchik38\Site2\Domain\Image\VO\Path;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

use function count;

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
            [],
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
    }
}
