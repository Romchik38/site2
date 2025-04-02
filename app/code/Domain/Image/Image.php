<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Image\Entities\Article;
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

    private Content $content;

    private bool $isLoaded = false;

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
            if (! $article instanceof Article) {
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
                $found      = false;
                foreach ($languages as $languageExist) {
                    if ($languageId() === $languageExist()) {
                        $found = true;
                        break;
                    }
                }
                if ($found === false) {
                    throw new InvalidArgumentException(
                        'param image translate language has non expected language'
                    );
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

    /** @todo test */
    /** @return array<int,Article> */
    public function getArticles(): array
    {
        return $this->articles;
    }

    public function getAuthor(): AuthorId
    {
        return $this->authorId;
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

    /** @todo test */
    public function changePath(Path $path): void
    {
        $this->path = $path;
    }

    /** @todo test */
    public function loadContent(Content $content): void
    {
        $this->content  = $content;
        $this->isLoaded = true;
    }

    /** @todo test */
    public function reName(Name $name): void
    {
        $this->name = $name;
    }

    /** @todo test */
    /**
     * @param array<int,mixed|Article> $articles
     * @param array<int,mixed|LanguageId> $languages
     * @param array<int,mixed|Translate> $translates
     * @throws InvalidArgumentException
     * */
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

    /** @todo test */
    /**
     * @param array<int,mixed|Article> $articles
     * @param array<int,mixed|LanguageId> $languages
     * @param array<int,mixed|Translate> $translates
     * @throws InvalidArgumentException
     * */
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

    /** @todo test */
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

    /** @todo test */
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
}
