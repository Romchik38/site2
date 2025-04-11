<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Audio\Entities;

use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Audio\Entities\Content;
use Romchik38\Site2\Domain\Audio\Entities\Translate;
use Romchik38\Site2\Domain\Audio\VO\Description;
use Romchik38\Site2\Domain\Audio\VO\Path;
use Romchik38\Site2\Domain\Audio\VO\Size;
use Romchik38\Site2\Domain\Audio\VO\Type;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class TranslateTest extends TestCase
{
    /**
     * Tested:
     *  - getLanguage
     *  - getDescription
     *  - getPath
     */
    public function testConstruct(): void
    {
        $description = new Description('some description');
        $language    = new LanguageId('en');
        $path        = new Path('some/file1.mp3');
        $translate   = new Translate($language, $description, $path);

        $this->assertSame($description, $translate->getDescription());
        $this->assertSame($language, $translate->getLanguage());
        $this->assertSame($path, $translate->getPath());
    }

    public function testGetContentReturnsNull(): void
    {
        $description = new Description('some description');
        $language    = new LanguageId('en');
        $path        = new Path('some/file1.mp3');
        $translate   = new Translate($language, $description, $path);

        $this->assertSame(null, $translate->getContent());
    }

    /**
     * Tested:
     *   getContent
     *   loadContent
     *   isContentLoaded (var)
     */
    public function testGetContent(): void
    {
        $description = new Description('some description');
        $language    = new LanguageId('en');
        $path        = new Path('some/file1.mp3');
        $translate   = new Translate($language, $description, $path);

        $content = new Content(
            's01191z+cs',
            new Type('mp3'),
            new Size(20521)
        );

        $this->assertSame(false, $translate->isContentLoaded);

        $translate->loadContent($content);

        $this->assertSame(true, $translate->isContentLoaded);

        $this->assertSame($content, $translate->getContent());
    }
}
