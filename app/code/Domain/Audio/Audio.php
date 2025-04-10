<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Audio;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Audio\Entities\Article;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use Romchik38\Site2\Domain\Audio\Entities\Translate;
use Romchik38\Site2\Domain\Audio\VO\Name;
use Romchik38\Site2\Domain\Audio\Entities\Author;
use Romchik38\Site2\Domain\Audio\VO\Id;

/** 
 * @todo implement
 * @todo test
 */
final class Audio
{
    /** @var array<int,Article> $articles */
    private readonly array $articles;
    
    private ContentInterface $content;

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
        private Author $author,
        array $articles,
        array $languages,
        array $translates
    ) {
        foreach ($languages as $language) {
            if (! $language instanceof LanguageId) {
                throw new InvalidArgumentException('param audio language id is invalid');
            }
        }
        $this->languages = $languages;

        foreach ($articles as $article) {
            if (! $article instanceof Article) {
                throw new InvalidArgumentException('param audio article id is invalid');
            }
            if ($article->active === true && $active === false) {
                throw new InvalidArgumentException('param audio article active and audio active are different');
            }
        }
        $this->articles = $articles;

        foreach ($translates as $translate) {
            if (! $translate instanceof Translate) {
                throw new InvalidArgumentException('param audio translate is invalid');
            } else {
                if ($this->languageCheck($translate, $languages) === false) {
                    throw new InvalidArgumentException(
                        'param audio translate language has non expected language'
                    );
                } else {
                    $languageId                      = $translate->getLanguage();
                    $this->translates[$languageId()] = $translate;
                }
            }
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
                    'param audio author is not active, activate it first'
                );
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

    public function getContent(): ?ContentInterface
    {
        if ($this->isLoaded === true) {
            return $this->content;
        } else {
            return null;
        }
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
                'param image translate language has non expected language'
            );
        } else {
            $languageId                      = $translate->getLanguage();
            $this->translates[$languageId()] = $translate;
        }
    }

    public function loadContent(ContentInterface $content): void
    {
        $this->content  = $content;
        $this->isLoaded = true;
    }

    public function reName(Name $name): void
    {
        $this->name = $name;
    }
    
    /**
     * @todo 
     * - Requirements to become active:
     *   - id is set
     *   - author is active
     * @throws CouldNotChangeActivityException 
     * */
    public function activate(): void
    {
        if ($this->active === true) {
            return;
        }

        if ($this->id === null) {
            throw new CouldNotChangeActivityException('Audio id is invalid');
        }

        if (count($this->languages) > count($this->translates)) {
            throw new CouldNotChangeActivityException('Audio has missing translates');
        }

        foreach ($this->languages as $language) {
            $check = $this->translates[$language()] ?? null;
            if ($check === null) {
                throw new CouldNotChangeActivityException(
                    sprintf('Audio has missing translates %s', $language())
                );
            }
        }

        if ($this->isLoaded === false) {
            throw new CouldNotChangeActivityException(
                sprintf('Audio content must be loaded before activation')
            );
        }

        if ($this->author->active === false) {
            throw new CouldNotChangeActivityException(
                'Audio author is not active, activate it first'
            );
        }

        $this->active = true;
    }

    /**
     * @throws CouldNotChangeActivityException 
     * */    
    public function deactivate(): void
    {
        if ($this->active === false) {
            return;
        }

        foreach ($this->articles as $article) {
            if ($article->active === true) {
                throw new CouldNotChangeActivityException(sprintf(
                    'Audio is used in article %s. Change it first',
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
        array $languages,
        array $translates = []
    ): self {
        return new self(
            null,
            false,
            $name,
            $author,
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
        Id $id,
        bool $active,
        Name $name,
        Author $author,
        array $articles,
        array $languages,
        array $translates
    ): self {
        return new self(
            $id,
            $active,
            $name,
            $author,
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