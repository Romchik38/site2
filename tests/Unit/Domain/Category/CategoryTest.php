<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Domain\Category;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Category\Category;
use Romchik38\Site2\Domain\Category\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\Category\CouldNotDeleteTranslateException;
use Romchik38\Site2\Domain\Category\Entities\Article;
use Romchik38\Site2\Domain\Category\Entities\Translate;
use Romchik38\Site2\Domain\Category\VO\Description;
use Romchik38\Site2\Domain\Category\VO\Identifier as CategoryId;
use Romchik38\Site2\Domain\Category\VO\Name;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use stdClass;

use function sprintf;

final class CategoryTest extends TestCase
{
    /**
     * Tested:
     *   - create
     *   - getId (null)
     *   - getTranslate
     *   - getTranslates
     *   - isActive
     */
    public function testCreate(): void
    {
        $id         = new CategoryId('traffic');
        $languageEn = new LanguageId('en');
        $languageUk = new LanguageId('uk');
        $languages  = [$languageEn, $languageUk];

        $descriptionEn = new Description('Some description');
        $nameEn        = new Name('Some name');
        $translateEn   = new Translate($languageEn, $descriptionEn, $nameEn);
        $translates    = [$translateEn];

        $category = Category::create(
            $id,
            $languages,
            $translates
        );

        $this->assertSame($translateEn, $category->getTranslate('en'));
        $this->assertSame([$translateEn], $category->getTranslates());
        $this->assertSame($id, $category->getId());
        $this->assertSame(false, $category->isActive());
    }

    public function testCreateThrowsErrorEmptyLanguages(): void
    {
        $id         = new CategoryId('traffic');
        $languages  = [];
        $translates = [];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Category::ERROR_EMPTY_LANGUAGE_LIST);

        Category::create($id, $languages, $translates);
    }

    public function testCreateThrowsErrorWrongLanguageInstance(): void
    {
        $id         = new CategoryId('traffic');
        $languages  = [new stdClass()];
        $translates = [];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Category::ERROR_WRONG_LANGUAGE_INSTANCE);

        Category::create($id, $languages, $translates);
    }

    public function testCreateThrowsErrorWrongTranslateLanguage(): void
    {
        $id         = new CategoryId('traffic');
        $languageEn = new LanguageId('en');
        $languageUk = new LanguageId('uk');
        $languageFr = new LanguageId('fr');
        $languages  = [$languageEn, $languageUk];

        $descriptionFr = new Description('Quelques descriptions');
        $nameFr        = new Name('Un nom');
        $translateFr   = new Translate($languageFr, $descriptionFr, $nameFr);
        $translates    = [$translateFr];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Category::ERROR_WRONG_TRANSLATE_LANGUAGE);

        Category::create($id, $languages, $translates);
    }

    public function testCreateThrowsErrorWrongTranslateInstance(): void
    {
        $id         = new CategoryId('traffic');
        $languageEn = new LanguageId('en');
        $languageUk = new LanguageId('uk');
        $languages  = [$languageEn, $languageUk];

        $translates = [new stdClass()];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Category::ERROR_WRONG_TRANSLATE_INSTANCE);

        Category::create($id, $languages, $translates);
    }

    public function testAddTranslate(): void
    {
        $id         = new CategoryId('traffic');
        $languageEn = new LanguageId('en');
        $languageUk = new LanguageId('uk');
        $languages  = [$languageEn, $languageUk];

        $translates = [];

        $category = Category::create(
            $id,
            $languages,
            $translates
        );

        $descriptionEn = new Description('Some description');
        $nameEn        = new Name('Some name');
        $translateEn   = new Translate($languageEn, $descriptionEn, $nameEn);

        $category->addTranslate($translateEn);
        $this->assertSame($translateEn, $category->getTranslate('en'));
    }

    public function testAddTranslateThrowsErrorOnWrontranslateLanguage(): void
    {
        $id         = new CategoryId('traffic');
        $languageEn = new LanguageId('en');
        $languageUk = new LanguageId('uk');
        $languageFr = new LanguageId('fr');
        $languages  = [$languageEn, $languageUk];

        $translates = [];

        $category = Category::create(
            $id,
            $languages,
            $translates
        );

        $descriptionFr = new Description('Quelques descriptions');
        $nameFr        = new Name('Un nom');
        $translateFr   = new Translate($languageFr, $descriptionFr, $nameFr);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Category::ERROR_WRONG_TRANSLATE_LANGUAGE);

        $category->addTranslate($translateFr);
    }

    public function testDeleteTranslate(): void
    {
        $id         = new CategoryId('traffic');
        $languageEn = new LanguageId('en');
        $languageUk = new LanguageId('uk');
        $languages  = [$languageEn, $languageUk];

        $descriptionEn = new Description('Some description');
        $nameEn        = new Name('Some name');
        $translateEn   = new Translate($languageEn, $descriptionEn, $nameEn);
        $translates    = [$translateEn];

        $category = Category::create(
            $id,
            $languages,
            $translates
        );

        $category->deleteTranslate('en');
        $this->assertSame([], $category->getTranslates());
    }

    /**
     * Tested:
     *   - getId (not null)
     *   - getArticles
     *   - getTranslates
     */
    public function testLoad(): void
    {
        $id = new CategoryId('some-id');

        $languageEn = new LanguageId('en');
        $languageUk = new LanguageId('uk');
        $languages  = [$languageEn, $languageUk];

        $descriptionEn = new Description('Some description');
        $nameEn        = new Name('Some name');
        $translateEn   = new Translate($languageEn, $descriptionEn, $nameEn);
        $translates    = [$translateEn];

        $article1 = new Article(new ArticleId('some-article-id'), false);
        $articles = [$article1];

        $category = Category::load(
            $id,
            false,
            $articles,
            $languages,
            $translates
        );

        $this->assertSame($id, $category->getId());
        $this->assertSame($translates, $category->getTranslates());
        $this->assertSame($articles, $category->getArticles());
    }

    public function testLoadThrowsErrorWrongArticleInstance(): void
    {
        $id = new CategoryId('some-id');

        $languageEn = new LanguageId('en');
        $languageUk = new LanguageId('uk');
        $languages  = [$languageEn, $languageUk];

        $descriptionEn = new Description('Some description');
        $nameEn        = new Name('Some name');
        $translateEn   = new Translate($languageEn, $descriptionEn, $nameEn);
        $translates    = [$translateEn];

        $article1 = new stdClass();
        $articles = [$article1];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Category::ERROR_WRONG_ARTICLE_INSTANCE);

        Category::load(
            $id,
            false,
            $articles,
            $languages,
            $translates
        );
    }

    /**
     * Tests:
     *   - isActive (true)
     */
    public function testDeleteTranslateThrowsErrorOnActive(): void
    {
        $id = new CategoryId('some-id');

        $languageEn = new LanguageId('en');
        $languageUk = new LanguageId('uk');
        $languages  = [$languageEn, $languageUk];

        $descriptionEn = new Description('Some description');
        $nameEn        = new Name('Some name');
        $translateEn   = new Translate($languageEn, $descriptionEn, $nameEn);

        $descriptionUk = new Description('Деякий опис');
        $nameUk        = new Name('Якесь ім\'я');
        $translateUk   = new Translate($languageUk, $descriptionUk, $nameUk);

        $translates = [$translateEn, $translateUk];

        $articles = [];

        $category = Category::load(
            $id,
            true,
            $articles,
            $languages,
            $translates
        );

        $this->expectException(CouldNotDeleteTranslateException::class);
        $this->expectExceptionMessage(Category::ERROR_DELETE_TRANSLATE_ACTIVE);

        $category->deleteTranslate('en');

        $this->assertSame(true, $category->isActive());
    }

    public function testActivate(): void
    {
        $id = new CategoryId('some-id');

        $languageEn = new LanguageId('en');
        $languageUk = new LanguageId('uk');
        $languages  = [$languageEn, $languageUk];

        $descriptionEn = new Description('Some description');
        $nameEn        = new Name('Some name');
        $translateEn   = new Translate($languageEn, $descriptionEn, $nameEn);

        $descriptionUk = new Description('Деякий опис');
        $nameUk        = new Name('Якесь ім\'я');
        $translateUk   = new Translate($languageUk, $descriptionUk, $nameUk);

        $translates = [$translateEn, $translateUk];

        $article1 = new Article(new ArticleId('some-article-id'), true);
        $articles = [$article1];

        $category = Category::load(
            $id,
            false,
            $articles,
            $languages,
            $translates
        );

        $category->activate();
        $this->assertSame(true, $category->isActive());
    }

    public function testActivateThrowsErrorOnEmptyArticles(): void
    {
        $id = new CategoryId('some-id');

        $languageEn = new LanguageId('en');
        $languageUk = new LanguageId('uk');
        $languages  = [$languageEn, $languageUk];

        $descriptionEn = new Description('Some description');
        $nameEn        = new Name('Some name');
        $translateEn   = new Translate($languageEn, $descriptionEn, $nameEn);

        $descriptionUk = new Description('Деякий опис');
        $nameUk        = new Name('Якесь ім\'я');
        $translateUk   = new Translate($languageUk, $descriptionUk, $nameUk);

        $translates = [$translateEn, $translateUk];

        $articles = [];

        $category = Category::load(
            $id,
            false,
            $articles,
            $languages,
            $translates
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $this->expectExceptionMessage(Category::ERROR_ACTIVATE_NO_ARTICLE);

        $category->activate();
    }

    /**
     * as min 1 article must be active, to activate the category
     */
    public function testActivateThrowsErrorOnNonActiveArticle(): void
    {
        $id = new CategoryId('some-id');

        $languageEn = new LanguageId('en');
        $languageUk = new LanguageId('uk');
        $languages  = [$languageEn, $languageUk];

        $descriptionEn = new Description('Some description');
        $nameEn        = new Name('Some name');
        $translateEn   = new Translate($languageEn, $descriptionEn, $nameEn);

        $descriptionUk = new Description('Деякий опис');
        $nameUk        = new Name('Якесь ім\'я');
        $translateUk   = new Translate($languageUk, $descriptionUk, $nameUk);

        $translates = [$translateEn, $translateUk];

        $article1 = new Article(new ArticleId('some-article-id 1'), false);
        $article2 = new Article(new ArticleId('some-article-id 2'), false);
        $articles = [$article1, $article2];

        $category = Category::load(
            $id,
            false,
            $articles,
            $languages,
            $translates
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $this->expectExceptionMessage(Category::ERROR_ACTIVATE_NO_ARTICLE);

        $category->activate();
    }

    public function testActivateThrowsErrorMissingTranslates(): void
    {
        $id = new CategoryId('some-id');

        $languageEn = new LanguageId('en');
        $languageUk = new LanguageId('uk');
        $languages  = [$languageEn, $languageUk];

        $descriptionEn = new Description('Some description');
        $nameEn        = new Name('Some name');
        $translateEn   = new Translate($languageEn, $descriptionEn, $nameEn);

        $translates = [$translateEn];

        $article1 = new Article(new ArticleId('some-article-id 1'), true);
        $articles = [$article1];

        $category = Category::load(
            $id,
            false,
            $articles,
            $languages,
            $translates
        );

        $this->expectException(CouldNotChangeActivityException::class);
        $this->expectExceptionMessage(sprintf(
            Category::ERROR_ACTIVATE_MISSING_TRANSLATE,
            'uk'
        ));

        $category->activate();
    }

    public function testDiactivate(): void
    {
        $id = new CategoryId('some-id');

        $languageEn = new LanguageId('en');
        $languageUk = new LanguageId('uk');
        $languages  = [$languageEn, $languageUk];

        $descriptionEn = new Description('Some description');
        $nameEn        = new Name('Some name');
        $translateEn   = new Translate($languageEn, $descriptionEn, $nameEn);

        $descriptionUk = new Description('Деякий опис');
        $nameUk        = new Name('Якесь ім\'я');
        $translateUk   = new Translate($languageUk, $descriptionUk, $nameUk);

        $translates = [$translateEn, $translateUk];

        $article1 = new Article(new ArticleId('some-article-id'), false);
        $articles = [$article1];

        $category = Category::load(
            $id,
            true,
            $articles,
            $languages,
            $translates
        );

        $category->deactivate();
        $this->assertSame(false, $category->isActive());
    }
}
