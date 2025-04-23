<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Category;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Category\Entities\Article;
use Romchik38\Site2\Domain\Category\Entities\Translate;
use Romchik38\Site2\Domain\Category\VO\Identifier;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

use function array_values;
use function count;
use function sprintf;

final class Category
{
    public const string ERROR_EMPTY_LANGUAGE_LIST      = 'category language list is empty';
    public const string ERROR_WRONG_TRANSLATE_LANGUAGE = 'category translate language has non expected language';
    public const string ERROR_WRONG_LANGUAGE_INSTANCE  = 'category language is invalid';
    public const string ERROR_WRONG_TRANSLATE_INSTANCE = 'category translate is invalid';
    public const string ERROR_WRONG_ARTICLE_INSTANCE   = 'category article is invalid';
    public const string ERROR_DELETE_TRANSLATE_ACTIVE  =
        'could not delete the translate, category is active. Diactivate it first';
    public const string ERROR_ACTIVATE_NO_ARTICLE      = 'category does not have any active article';
    public const ERROR_ACTIVATE_MISSING_TRANSLATE      = 'category has missing translate %s';
    public const ERROR_DIACTIVATE_HAS_ARTICLES         = 'category has active articles, remove them first';

    /** @var array<int,Article> $articles */
    private readonly array $articles;

    /** @var array<int,LanguageId> $languages */
    private readonly array $languages;

    /** @var array<string,Translate> $translates */
    private array $translates = [];

    /**
     * @param array<int,mixed|Article> $articles
     * @param array<int,mixed|LanguageId> $languages
     * @param array<int,mixed|Translate> $translates
     * @throws InvalidArgumentException
     * */
    private function __construct(
        private Identifier $id,
        private bool $active,
        array $articles,
        array $languages,
        array $translates
    ) {
        if (count($languages) === 0) {
            throw new InvalidArgumentException(self::ERROR_EMPTY_LANGUAGE_LIST);
        }
        foreach ($languages as $language) {
            if (! $language instanceof LanguageId) {
                throw new InvalidArgumentException(self::ERROR_WRONG_LANGUAGE_INSTANCE);
            }
        }
        $this->languages = $languages;

        foreach ($articles as $article) {
            if (! $article instanceof Article) {
                throw new InvalidArgumentException(self::ERROR_WRONG_ARTICLE_INSTANCE);
            }
        }
        $this->articles = $articles;

        foreach ($translates as $translate) {
            if (! $translate instanceof Translate) {
                throw new InvalidArgumentException(self::ERROR_WRONG_TRANSLATE_INSTANCE);
            } else {
                if ($this->languageCheck($translate, $languages) === false) {
                    throw new InvalidArgumentException(self::ERROR_WRONG_TRANSLATE_LANGUAGE);
                } else {
                    $languageId                      = $translate->getLanguage();
                    $this->translates[$languageId()] = $translate;
                }
            }
        }
    }

    /** @return array<int,Article> */
    public function getArticles(): array
    {
        return $this->articles;
    }

    public function getId(): Identifier
    {
        return $this->id;
    }

    public function getTranslate(string $language): ?Translate
    {
        return $this->translates[$language] ?? null;
    }

    /** @return array<int,Translate> */
    public function getTranslates(): array
    {
        return array_values($this->translates);
    }

    /** @throws InvalidArgumentException */
    public function addTranslate(Translate $translate): void
    {
        $checkResult = $this->languageCheck($translate, $this->languages);
        if ($checkResult === false) {
            throw new InvalidArgumentException(self::ERROR_WRONG_TRANSLATE_LANGUAGE);
        } else {
            $languageId                      = $translate->getLanguage();
            $this->translates[$languageId()] = $translate;
        }
    }

    /**
     * @throws CouldNotDeleteTranslateException
     * */
    public function deleteTranslate(string $language): void
    {
        if ($this->active === true) {
            throw new CouldNotDeleteTranslateException(self::ERROR_DELETE_TRANSLATE_ACTIVE);
        }
        $translates = array_values($this->translates);
        $arr        = [];
        foreach ($translates as $translate) {
            $translateLanguage = $translate->getLanguage();
            if ($translateLanguage() === $language) {
                continue;
            } else {
                $arr[$translateLanguage()] = $translate;
            }
        }

        $this->translates = $arr;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * - Requirements to become active:
     *   - has active article
     *   - has all translates
     *
     * @throws CouldNotChangeActivityException
     * */
    public function activate(): void
    {
        if ($this->active === true) {
            return;
        }

        foreach ($this->languages as $language) {
            $check = $this->translates[$language()] ?? null;
            if ($check === null) {
                throw new CouldNotChangeActivityException(
                    sprintf(self::ERROR_ACTIVATE_MISSING_TRANSLATE, $language())
                );
            }
        }

        if (count($this->articles) === 0) {
            throw new CouldNotChangeActivityException(self::ERROR_ACTIVATE_NO_ARTICLE);
        }

        $hasActiveArticle = false;
        foreach ($this->articles as $article) {
            if ($article->active === true) {
                $hasActiveArticle = true;
                break;
            }
        }
        if ($hasActiveArticle === false) {
            throw new CouldNotChangeActivityException(self::ERROR_ACTIVATE_NO_ARTICLE);
        }

        $this->active = true;
    }

    /**
     * - Requirements to become active:
     *   - no active articles
     *
     * @throws CouldNotChangeActivityException
     * */
    public function deactivate(): void
    {
        if ($this->active === false) {
            return;
        }

        foreach ($this->articles as $article) {
            if ($article->active === true) {
                throw new CouldNotChangeActivityException(self::ERROR_DIACTIVATE_HAS_ARTICLES);
            }
        }

        $this->active = false;
    }

    /**
     * @param array<int,mixed|LanguageId> $languages
     * @param array<int,mixed|Translate> $translates
     * @throws InvalidArgumentException
     * */
    public static function create(
        Identifier $id,
        array $languages,
        array $translates = []
    ): self {
        return new self(
            $id,
            false,
            [],
            $languages,
            $translates
        );
    }

    /**
     * @param array<int,mixed|Article> $articles
     * @param array<int,mixed|LanguageId> $languages
     * @param array<int,mixed|Translate> $translates
     * @throws InvalidArgumentException
     * */
    public static function load(
        Identifier $id,
        bool $active,
        array $articles,
        array $languages,
        array $translates
    ): self {
        return new self(
            $id,
            $active,
            $articles,
            $languages,
            $translates
        );
    }

    /** @param array<int,mixed|LanguageId> $languages */
    private function languageCheck(Translate $translate, array $languages): bool
    {
        $languageId = $translate->getLanguage();
        $found      = false;
        foreach ($languages as $language) {
            if ($languageId() === $language()) {
                $found = true;
                break;
            }
        }
        return $found;
    }
}
