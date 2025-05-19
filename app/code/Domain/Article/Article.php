<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Article\Entities\Audio;
use Romchik38\Site2\Domain\Article\Entities\Author;
use Romchik38\Site2\Domain\Article\Entities\Category;
use Romchik38\Site2\Domain\Article\Entities\Image;
use Romchik38\Site2\Domain\Article\Entities\Translate;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

use function array_values;
use function sprintf;

final class Article
{
    /** @var array<int,Category> $categories */
    private array $categories = [];

    /** @var array<int,LanguageId> $languages */
    private readonly array $languages;

    /** @var array<string,Translate> $translates */
    private array $translates = [];

    /**
     * @param array<int,mixed|LanguageId> $languages
     * @param array<int,mixed|Translates> $translates
     * @throws InvalidArgumentException
     */
    public function __construct(
        private ArticleId $articleId,
        private bool $active,
        private Author $author,
        private ?Image $image,
        private ?Audio $audio,
        array $categories,
        array $languages,
        array $translates
    ) {
        foreach ($categories as $category) {
            if (! $category instanceof Category) {
                throw new InvalidArgumentException('param article category is invalid');
            }
        }
        $this->categories = $categories;

        foreach ($languages as $language) {
            if (! $language instanceof LanguageId) {
                throw new InvalidArgumentException('param article language id is invalid');
            }
        }
        $this->languages = $languages;

        foreach ($translates as $translate) {
            if (! $translate instanceof Translate) {
                throw new InvalidArgumentException('param article translate is invalid');
            } else {
                if ($this->languageCheck($translate, $languages) === false) {
                    throw new InvalidArgumentException(
                        'param article translate language has non expected language'
                    );
                } else {
                    $languageId                      = $translate->getLanguage();
                    $this->translates[$languageId()] = $translate;
                }
            }
        }

        if ($active === true) {
            if ($image === null) {
                throw new InvalidArgumentException('param article image is invalid');
            }
            if ($audio === null) {
                throw new InvalidArgumentException('param article audio is invalid');
            }
            if (count($categories) === 0) {
                throw new InvalidArgumentException('param article categories is empty');
            }
        }
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

    /** @todo all methods below must be reviewed */
    public function getId(): ArticleId
    {
        return $this->articleId;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    /** @throws InvalidArgumentException - When translate is missing. */
    public function getTranslate(string $language): Translate
    {
        $translate = $this->translates[$language] ?? null;
        if ($translate === null) {
            throw new InvalidArgumentException(
                sprintf(
                    'Translate %s for Article id %s is missing',
                    $language,
                    ($this->articleId)(),
                )
            );
        }

        return $translate;
    }

    /** @return Translates[] */
    public function getAllTranslates(): array
    {
        return array_values($this->translates);
    }

    public function getCategory(string $categoryId): ?Category
    {
        return $this->categories[$categoryId] ?? null;
    }

    /** @return Category[] */
    public function getAllCategories(): array
    {
        return array_values($this->categories);
    }

    public function setId(ArticleId $id): self
    {
        $this->articleId = $id;
        return $this;
    }

    public function activate(): self
    {
        $this->active = true;
        return $this;
    }

    public function dectivate(): self
    {
        $this->active = false;
        return $this;
    }
}
