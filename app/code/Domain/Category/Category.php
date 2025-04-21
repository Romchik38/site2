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
        private ?Identifier $id,
        private bool $active,
        array $articles,
        array $languages,
        array $translates
    ) {
        if (count($languages) === 0) {
            throw new InvalidArgumentException('category language list is empty');
        }
        foreach ($languages as $language) {
            if (! $language instanceof LanguageId) {
                throw new InvalidArgumentException('param category language id is invalid');
            }
        }
        $this->languages = $languages;

        foreach ($articles as $article) {
            if (! $article instanceof Article) {
                throw new InvalidArgumentException('param category article id is invalid');
            }
        }
        $this->articles = $articles;

        foreach ($translates as $translate) {
            if (! $translate instanceof Translate) {
                throw new InvalidArgumentException('param category translate is invalid');
            } else {
                if ($this->languageCheck($translate, $languages) === false) {
                    throw new InvalidArgumentException(
                        'param category translate language has non expected language'
                    );
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

    public function getId(): ?Identifier
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
            throw new InvalidArgumentException(
                'param Category translate language has non expected language'
            );
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
            throw new CouldNotDeleteTranslateException(
                'Coould not delete translate, category is active. Diactivaye it first'
            );
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
     *   - id is set
     *
     * @throws CouldNotChangeActivityException
     * */
    public function activate(): void
    {
        if ($this->active === true) {
            return;
        }

        if ($this->id === null) {
            throw new CouldNotChangeActivityException('Category id is invalid');
        }

        if (count($this->languages) > count($this->translates)) {
            throw new CouldNotChangeActivityException('Category has missing translates');
        }

        foreach ($this->languages as $language) {
            $check = $this->translates[$language()] ?? null;
            if ($check === null) {
                throw new CouldNotChangeActivityException(
                    sprintf('Category has missing translates %s', $language())
                );
            }
        }

        $this->active = true;
    }

    public function deactivate(): void
    {
        if ($this->active === false) {
            return;
        }

        $this->active = false;
    }

    /**
     * @param array<int,mixed|LanguageId> $languages
     * @param array<int,mixed|Translate> $translates
     * @throws InvalidArgumentException
     * */
    public static function create(
        array $languages,
        array $translates = []
    ): self {
        return new self(
            null,
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
