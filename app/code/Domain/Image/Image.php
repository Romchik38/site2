<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Image\VO\Path;
use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Domain\Image\VO\Name;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use Romchik38\Site2\Domain\Article\VO\ArticleId;
use Romchik38\Site2\Domain\Image\Entities\Content;
use Romchik38\Site2\Domain\Image\Entities\Translate;

final class Image
{
    /** @var array<int,ArticleId> $articles */
    private readonly array $articles;

    private Content $content;

    private bool $isLoaded = false;

    /** @var array<int,LanguageId> $languages */
    private readonly array $languages;

    /** @var array<string,Translate> $translates */
    private array $translates = [];

    /**
     * @param array<int,mixed|ArticleId> $articles
     * @param array<int,mixed|LanguageId> $languages
     * @param array<int,mixed|Translate>
     * */
    private function __construct(
        private ?Id $id,
        private bool $active,
        private Name $name,
        private AuthorId $authorId,
        private Path $path,
        array $languages,
        array $articles,
        array $translates
    ) {
        foreach ($languages as $language) {
            if (! $language instanceof LanguageId) {
                throw new InvalidArgumentException('param image language id is invalid');
            }
        }
        $this->languages = $languages;

        foreach ($articles as $article) {
            if (! $article instanceof ArticleId) {
                throw new InvalidArgumentException('param image article id is invalid');
            }
        }
        $this->articles = $articles;

        foreach ($translates as $translate) {
            if (! $translate instanceof Translate) {
                throw new InvalidArgumentException('param image translate is invalid');
            } else {
                // language check
                $languageId = $translate->getLanguage();
                $found = false;
                foreach ($languages as $languageExist) {
                    if ($languageId() === $languageExist()) {
                        $found = true;
                        break;
                    }
                }
                if ($found === false) {
                    throw new InvalidArgumentException('param image translate language is invalid');
                } else {
                    $this->translates[$languageId()] = $translate;
                }
            }
        }
    }

    public function getContent(): ?Content
    {
        if ($this->isLoaded === true) {
            return $this->content;
        } else {
            return null;
        }
    }

    public function loadContent(Content $content): void
    {
        $this->content = $content;
        $this->isLoaded = true;
    }

    public static function create(
        Name $name,
        AuthorId $authorId,
        Path $path,
        array $languages,
        array $articles = [],
        array $translates = []
    ): self {
        return new self(
            null,
            false,
            $name,
            $authorId,
            $path,
            $languages,
            $articles,
            $translates
        );
    }

    public static function load(
        Id $id,
        bool $active,
        Name $name,
        AuthorId $authorId,
        Path $path,
        array $languages,
        array $articles,
        array $translates
    ): self {
        return new self(
            $id,
            $active,
            $name,
            $authorId,
            $path,
            $languages,
            $articles,
            $translates
        );
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

        if (count($this->articles) > 0) {
            throw new CouldNotChangeActivityException('Author is used in articles. Change it first');
        }

        $this->active = false;
    }
}
