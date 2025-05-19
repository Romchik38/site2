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
    private(set) array $categories = [];

    /** @var array<int,LanguageId> $languages */
    private readonly array $languages;

    /** @var array<string,Translate> $translates */
    private array $translates = [];

    /**
     * @param array<int,mixed|LanguageId> $languages
     * @param array<int,mixed|Translates> $translates
     * @throws InvalidArgumentException
     */
    private function __construct(
        private(set) ArticleId $articleId,
        private(set) bool $active,
        private(set) ?Audio $audio,
        private(set) Author $author,
        private(set) ?Image $image,
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

    /** @todo implement */
    public function activate(): self
    {
        $this->active = true;
        return $this;
    }
    
    /** @throws InvalidArgumentException */
    public function addTranslate(Translate $translate): void
    {
        $checkResult = $this->languageCheck($translate, $this->languages);
        if ($checkResult === false) {
            throw new InvalidArgumentException(
                'param article translate language has non expected language'
            );
        } else {
            $languageId                      = $translate->getLanguage();
            $this->translates[$languageId()] = $translate;
        }
    }

    /** @throws InvalidArgumentException */
    public function changeAudio(Audio $audio): void
    {
        if ($this->active === true && $audio->active === false) {
            throw new InvalidArgumentException('Article audio not active');
        }
        $this->audio = $audio;
    }

    /** @throws InvalidArgumentException */
    public function changeAuthor(Author $author): void
    {
        if ($this->active === true && $author->active === false) {
            throw new InvalidArgumentException('Article author not active');
        }
        $this->author = $author;
    }

    /** @throws InvalidArgumentException */
    public function changeImage(Image $image): void
    {
        if ($this->active === true && $image->active === false) {
            throw new InvalidArgumentException('Article image not active');
        }
        $this->image = $image;
    }

    /** @todo implement */
    public function dectivate(): self
    {
        $this->active = false;
        return $this;
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
