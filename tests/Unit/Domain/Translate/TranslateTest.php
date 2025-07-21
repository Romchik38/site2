<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Translate;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use Romchik38\Site2\Domain\Translate\Entities\Phrase;
use Romchik38\Site2\Domain\Translate\Translate;
use Romchik38\Site2\Domain\Translate\VO\Identifier as TranslateId;
use Romchik38\Site2\Domain\Translate\VO\Text;

final class TranslateTest extends TestCase
{
    /**
     * also tested:
     *   - getPhrases
     */
    public function testConstruct(): void
    {
        $id       = new TranslateId('key.1');
        $phraseEn = new Phrase(new LanguageId('en'), new Text('text 1'));
        $phrases  = [$phraseEn];

        $model = new Translate($id, $phrases);

        $this->assertSame($id, $model->identifier);
        $this->assertSame($phrases, $model->getPhrases());
    }

    public function testConstructThrowsErrorOnWrongPhrase(): void
    {
        $id       = new TranslateId('key.1');
        $phraseEn = 'wrong';     // wrong
        $phrases  = [$phraseEn];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Translate::INVALID_PHRASE);

        new Translate($id, $phrases);
    }

    public function testAddPhrase(): void
    {
        $id       = new TranslateId('key.1');
        $phraseEn = new Phrase(new LanguageId('en'), new Text('text 1'));
        $phrases  = [$phraseEn];

        $model = new Translate($id, $phrases);
        $this->assertSame($phrases, $model->getPhrases());

        $phraseEnNew = new Phrase(new LanguageId('en'), new Text('text 1 new'));
        $model->addPhrase($phraseEnNew);
        $this->assertSame([$phraseEnNew], $model->getPhrases());
    }
}
