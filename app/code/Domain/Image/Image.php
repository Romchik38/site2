<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Image\Entities\Article;
use Romchik38\Site2\Domain\Image\Entities\Author;
use Romchik38\Site2\Domain\Image\Entities\Banner;
use Romchik38\Site2\Domain\Image\Entities\Content;
use Romchik38\Site2\Domain\Image\Entities\Translate;
use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Domain\Image\VO\Name;
use Romchik38\Site2\Domain\Image\VO\Path;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

use function array_values;
use function count;
use function sprintf;

final class Image
{
    /** @var array<int,Article> $articles */
    private readonly array $articles;

    /** @var array<int,Banner> $banners */
    public readonly array $banners;

    private Content $content;

    private bool $isLoaded = false;

    /** @var array<int,LanguageId> $languages */
    private readonly array $languages;

    /** @var array<string,Translate> $translates */
    private array $translates = [];

    /**
     * @param array<int,mixed|Article> $articles
     * @param array<int,mixed|Banner> $banners
     * @param array<int,mixed|LanguageId> $languages
     * @param array<int,mixed|Translate> $translates
     * @throws InvalidArgumentException
     * */
    private function __construct(
        private ?Id $id,
        private bool $active,
        private Name $name,
        private Author $author,
        private readonly Path $path,
        array $languages,
        array $articles,
        array $banners,
        array $translates
    ) {
        foreach ($languages as $language) {
            if (! $language instanceof LanguageId) {
                throw new InvalidArgumentException('param image language id is invalid');
            }
        }
        $this->languages = $languages;

        foreach ($articles as $article) {
            if (! $article instanceof Article) {
                throw new InvalidArgumentException('param image article is invalid');
            }
            if ($article->active === true && $active === false) {
                throw new InvalidArgumentException('params image article active and image active are different');
            }
        }
        $this->articles = $articles;

        /** @todo 2 tests */
        foreach ($banners as $banner) {
            if (! $banner instanceof Banner) {
                throw new InvalidArgumentException('param image banner is invalid');
            }
            if ($banner->active === true && $active === false) {
                throw new InvalidArgumentException('params image banner active and image active are different');
            }
        }
        $this->banners = $banners;

        foreach ($translates as $translate) {
            if (! $translate instanceof Translate) {
                throw new InvalidArgumentException('param image translate is invalid');
            } else {
                if ($this->languageCheck($translate, $languages) === false) {
                    throw new InvalidArgumentException(
                        'param image translate language has non expected language'
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

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function getContent(): ?Content
    {
        if ($this->isLoaded === true) {
            return $this->content;
        } else {
            return null;
        }
    }

    public function getId(): ?Id
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getPath(): Path
    {
        return $this->path;
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

    public function isActive(): bool
    {
        return $this->active;
    }

    /** @throws InvalidArgumentException */
    public function addTranslate(Translate $translate): void
    {
        $checkResult = $this->languageCheck($translate, $this->languages);
        if ($checkResult === false) {
            throw new InvalidArgumentException(
                'param image translate language has non expected language'
            );
        } else {
            $languageId                      = $translate->getLanguage();
            $this->translates[$languageId()] = $translate;
        }
    }

    /** @throws InvalidArgumentException */
    public function changeAuthor(Author $author): void
    {
        if ($this->active === false) {
            $this->author = $author;
        } else {
            if ($author->active === true) {
                $this->author = $author;
            } else {
                throw new InvalidArgumentException(
                    'param Image author is not active, activate it first'
                );
            }
        }
    }

    public function loadContent(Content $content): void
    {
        $this->content  = $content;
        $this->isLoaded = true;
    }

    public function reName(Name $name): void
    {
        $this->name = $name;
    }

    /** @throws CouldNotChangeActivityException */
    public function activate(): void
    {
        if ($this->active === true) {
            return;
        }

        if ($this->id === null) {
            throw new CouldNotChangeActivityException('Image id is invalid');
        }

        if (count($this->languages) > count($this->translates)) {
            throw new CouldNotChangeActivityException('Image has missing translates');
        }

        foreach ($this->languages as $language) {
            $check = $this->translates[$language()] ?? null;
            if ($check === null) {
                throw new CouldNotChangeActivityException(
                    sprintf('Image has missing translates %s', $language())
                );
            }
        }

        if ($this->isLoaded === false) {
            throw new CouldNotChangeActivityException(
                sprintf('Image content must be loaded before activation')
            );
        }

        if ($this->author->active === false) {
            throw new CouldNotChangeActivityException(
                'Image author is not active, activate it first'
            );
        }

        $this->active = true;
    }

    /**
     * @throws CouldNotChangeActivityException
     */
    public function deactivate(): void
    {
        if ($this->active === false) {
            return;
        }

        foreach ($this->articles as $article) {
            if ($article->active === true) {
                throw new CouldNotChangeActivityException(sprintf(
                    'Image is used in article %s. Change it first',
                    (string) $article->id
                ));
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
        Name $name,
        Author $author,
        Path $path,
        array $languages,
        array $translates = []
    ): self {
        return new self(
            null,
            false,
            $name,
            $author,
            $path,
            $languages,
            [],
            [],
            $translates
        );
    }

    /**
     * @param array<int,mixed|Article> $articles
     * @param array<int,mixed|Banner> $banners
     * @param array<int,mixed|LanguageId> $languages
     * @param array<int,mixed|Translate> $translates
     * @throws InvalidArgumentException
     * */
    public static function load(
        Id $id,
        bool $active,
        Name $name,
        Author $author,
        Path $path,
        array $languages,
        array $articles,
        array $banners,
        array $translates
    ): self {
        return new self(
            $id,
            $active,
            $name,
            $author,
            $path,
            $languages,
            $articles,
            $banners,
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
