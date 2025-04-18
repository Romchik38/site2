<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Audio;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Audio\Entities\Article;
use Romchik38\Site2\Domain\Audio\Entities\Translate;
use Romchik38\Site2\Domain\Audio\VO\Id;
use Romchik38\Site2\Domain\Audio\VO\Name;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

use function array_values;
use function count;
use function sprintf;

/**
 * @todo test
 */
final class Audio
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
        private ?Id $id,
        private bool $active,
        private Name $name,
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

    /** @return array<int,Article> */
    public function getArticles(): array
    {
        return $this->articles;
    }

    public function getId(): ?Id
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
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
                'param audio translate language has non expected language'
            );
        } else {
            $languageId                      = $translate->getLanguage();
            $this->translates[$languageId()] = $translate;
        }
    }

    /**
     * @todo test
     * @throws CouldNotDeleteTranslateException
     * */
    public function deleteTranslate(string $language): void
    {
        if ($this->active === true) {
            throw new CouldNotDeleteTranslateException(
                'Coould not delete translate, audio is active. Diactivaye it first'
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

    public function reName(Name $name): void
    {
        $this->name = $name;
    }

    /**
     * @todo
     * - Requirements to become active:
     *   - id is set
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

        if ($this->isContentLoaded() === false) {
            throw new CouldNotChangeActivityException(
                sprintf('Audio content must be loaded before activation')
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
        array $languages,
        array $translates = []
    ): self {
        return new self(
            null,
            false,
            $name,
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
        array $articles,
        array $languages,
        array $translates
    ): self {
        return new self(
            $id,
            $active,
            $name,
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

    private function isContentLoaded(): bool
    {
        foreach ($this->languages as $language) {
            $translate = $this->translates[$language()] ?? null;
            if ($translate === null) {
                return false;
            } else {
                if ($translate->isContentLoaded === false) {
                    return false;
                }
            }
        }

        return true;
    }
}
