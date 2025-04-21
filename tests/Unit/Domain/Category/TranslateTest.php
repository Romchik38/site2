<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Category;

use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Category\Entities\Translate;
use Romchik38\Site2\Domain\Category\VO\Description;
use Romchik38\Site2\Domain\Category\VO\Name;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class TranslateTest extends TestCase
{
    /**
     * Tested:
     *   - changeDescription
     *   - getDescription
     */
    public function testChangeDescription(): void
    {
        $description = new Description('Some description 1');
        $name        = new Name('Some category name 1');
        $language    = new LanguageId('en');
        $translate   = new Translate(
            $language,
            $description,
            $name
        );

        $newDescription = new Description('Some description 2');
        $translate->changeDescription($newDescription);

        $this->assertSame($newDescription, $translate->getDescription());
    }

    /**
     * Tested:
     *   - getName
     *   - reName
     */
    public function testRenameDescription(): void
    {
        $description = new Description('Some description 1');
        $name        = new Name('Some category name 1');
        $language    = new LanguageId('en');
        $translate   = new Translate(
            $language,
            $description,
            $name
        );

        $newName = new Name('Some category name 2');
        $translate->reName($newName);

        $this->assertSame($newName, $translate->getName());
    }

    public function testGetLanguage(): void
    {
        $description = new Description('Some description 1');
        $name        = new Name('Some category name 1');
        $language    = new LanguageId('en');
        $translate   = new Translate(
            $language,
            $description,
            $name
        );

        $this->assertSame($language, $translate->getLanguage());
    }
}
