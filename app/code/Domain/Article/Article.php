<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article;

use DateTime;
use InvalidArgumentException;
use Romchik38\Site2\Domain\Article\Entities\Audio;
use Romchik38\Site2\Domain\Article\Entities\Author;
use Romchik38\Site2\Domain\Article\Entities\Category;
use Romchik38\Site2\Domain\Article\Entities\Image;
use Romchik38\Site2\Domain\Article\Entities\Translate;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Article\VO\Views;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

use function array_values;
use function count;
use function sprintf;

final class Article
{
    public const SAVE_DATE_FORMAT = 'Y-m-d G:i:s';

    /** @var array<int,Category> $categories */
    private array $categories = [];

    /** @var array<int,LanguageId> $languages */
    private readonly array $languages;

    /** @var array<string,Translate> $translates */
    private array $translates = [];

    /**
     * @param array<int,mixed|Category> $categories
     * @param array<int,mixed|LanguageId> $languages
     * @param array<int,mixed|Translates> $translates
     * @throws InvalidArgumentException
     */
    public function __construct(
        private(set) ArticleId $id,
        private(set) bool $active,
        private(set) ?Audio $audio,
        private(set) Author $author,
        private(set) ?Image $image,
        public readonly DateTime $createdAt,
        private(set) DateTime $updatedAt,
        public Views $views,
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
                    $languageId                      = $translate->language;
                    $this->translates[$languageId()] = $translate;
                }
            }
        }

        if ($active === true) {
            if ($image === null) {
                throw new InvalidArgumentException('param article image is invalid');
            } else {
                if ($image->active === false) {
                    throw new InvalidArgumentException('param article image is not active');
                }
            }
            if ($audio === null) {
                throw new InvalidArgumentException('param article audio is invalid');
            } else {
                if ($audio->active === false) {
                    throw new InvalidArgumentException('param article audio is not active');
                }
            }

            if (count($translates) < count($languages)) {
                throw new InvalidArgumentException('Article has missing translates');
            }

            if ($author->active === false) {
                throw new InvalidArgumentException('param article author is not active');
            }
        }

        if ($createdAt > $updatedAt) {
            throw new InvalidArgumentException('param article created at is bigger than updated at');
        }
    }

    /** @throws CouldNotChangeActivityException */
    public function activate(): void
    {
        if ($this->active === true) {
            return;
        }

        if ($this->image === null) {
            throw new CouldNotChangeActivityException('Could not activate article: image not set');
        } else {
            if ($this->image->active === false) {
                throw new CouldNotChangeActivityException(
                    'Could not activate article: image is not active'
                );
            }
        }

        if ($this->audio === null) {
            throw new CouldNotChangeActivityException('Could not activate article: audio not set');
        } else {
            if ($this->audio->active === false) {
                throw new CouldNotChangeActivityException(
                    'Could not activate article: audio is not active'
                );
            }
        }

        if (count($this->languages) > count($this->translates)) {
            throw new CouldNotChangeActivityException('Article has missing translates');
        }

        foreach ($this->languages as $language) {
            $check = $this->translates[$language()] ?? null;
            if ($check === null) {
                throw new CouldNotChangeActivityException(
                    sprintf('Article has missing translates %s', $language())
                );
            }
        }

        if (count($this->categories) === 0) {
            throw new CouldNotChangeActivityException('Article must be at least in one category');
        }

        if ($this->author->active === false) {
            throw new CouldNotChangeActivityException('Could not activate article: author is not active');
        }

        $this->active = true;
    }

    /** @throws InvalidArgumentException */
    public function addTranslate(Translate $translate): void
    {
        $checkResult = $this->languageCheck($translate, $this->languages);
        if ($checkResult === false) {
            throw new InvalidArgumentException(
                'param article translate language has non expected language'
            );
        }
        $languageId   = (string) $translate->language;
        $oldTranslate = $this->translates[$languageId] ?? null;
        if ($oldTranslate !== null) {
            $this->updateOnTranslate($oldTranslate, $translate);
        } else {
            $this->updatedAt = new DateTime();
        }
        $this->translates[$languageId] = $translate;
    }

    /** @throws InvalidArgumentException */
    public function changeAudio(Audio $audio): void
    {
        if ($this->active === true && $audio->active === false) {
            throw new InvalidArgumentException('Article audio not active');
        }
        if ($this->audio !== null) {
            if (($this->audio->id)() !== ($audio->id)()) {
                $this->updatedAt = new DateTime();
            }
        } else {
            $this->updatedAt = new DateTime();
        }
        $this->audio = $audio;
    }

    /** @throws InvalidArgumentException */
    public function changeAuthor(Author $author): void
    {
        if ($this->active === true && $author->active === false) {
            throw new InvalidArgumentException('Article author not active');
        }
        if (($this->author->id)() !== ($author->id)()) {
            $this->updatedAt = new DateTime();
        }
        $this->author = $author;
    }

    /**
     * @param array<int,mixed|Category> $newCategories
     * @throws InvalidArgumentException
     * */
    public function changeCategories(array $newCategories): void
    {
        foreach ($newCategories as $newCategory) {
            if (! $newCategory instanceof Category) {
                throw new InvalidArgumentException('Article category is invalid');
            }
        }

        $this->categories = $newCategories;
    }

    /** @throws InvalidArgumentException */
    public function changeImage(Image $image): void
    {
        if ($this->active === true && $image->active === false) {
            throw new InvalidArgumentException('Article image not active');
        }
        if ($this->image !== null) {
            if (($this->image->id)() !== ($image->id)()) {
                $this->updatedAt = new DateTime();
            }
        } else {
            $this->updatedAt = new DateTime();
        }
        $this->image = $image;
    }

    /**
     * @param array<int,mixed|Category> $categories
     * @param array<int,mixed|LanguageId> $languages
     * @param array<int,mixed|Translates> $translates
     * @throws InvalidArgumentException
     * */
    public static function create(
        ArticleId $articleId,
        Author $author,
        array $languages,
        ?Audio $audio = null,
        ?Image $image = null,
        DateTime $createdAt = new DateTime(),
        DateTime $updatedAt = new DateTime(),
        Views $views = new Views(0),
        array $categories = [],
        array $translates = []
    ): self {
        return new self(
            $articleId,
            false,
            $audio,
            $author,
            $image,
            $createdAt,
            $updatedAt,
            $views,
            $categories,
            $languages,
            $translates
        );
    }

    public function incrementViews(): void
    {
        $this->views = new Views(($this->views)() + 1);
    }

    /** @throws CouldNotChangeActivityException */
    public function deactivate(): void
    {
        if ($this->active === false) {
            return;
        }

        foreach ($this->categories as $category) {
            if ($category->active === true && $category->articleCount === 1) {
                throw new CouldNotChangeActivityException(sprintf(
                    'Category %s is active and has only one article',
                    (string) $category->id
                ));
            }
        }
        $this->active = false;
    }

    public function formatCreatedAt(): string
    {
        return $this->createdAt->format(self::SAVE_DATE_FORMAT);
    }

    public function formatUpdatedAt(): string
    {
        return $this->updatedAt->format(self::SAVE_DATE_FORMAT);
    }

    /** @return array<int,Category> */
    public function getCategories(): array
    {
        return $this->categories;
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
        $languageId = $translate->language;
        $found      = false;
        foreach ($languages as $language) {
            if ($languageId() === $language()) {
                $found = true;
                break;
            }
        }
        return $found;
    }

    private function updateOnTranslate(Translate $old, Translate $new): void
    {
        if (
            ($old->name)() !== ($new->name)() ||
            ($old->shortDescription)() !== ($new->shortDescription)() ||
            ($old->description)() !== ($new->description)()
        ) {
            $this->updatedAt = new DateTime();
        }
    }
}
