<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Author;

use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Author\Author;
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
}
