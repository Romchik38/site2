<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Page;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use Romchik38\Site2\Domain\Page\Entities\Translate;
use Romchik38\Site2\Domain\Page\VO\Id;
use Romchik38\Site2\Domain\Page\VO\Url;

use function array_values;
use function count;
use function sprintf;

final class Page
{
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
        public readonly ?Id $id,
        private(set) bool $active,
        public Url $url,
        array $languages,
        array $translates
    ) {
        foreach ($languages as $language) {
            if (! $language instanceof LanguageId) {
                throw new InvalidArgumentException('param page language id is invalid');
            }
        }
        $this->languages = $languages;

        foreach ($translates as $translate) {
            if (! $translate instanceof Translate) {
                throw new InvalidArgumentException('param page translate is invalid');
            } else {
                if ($this->languageCheck($translate->language, $languages) === false) {
                    throw new InvalidArgumentException(
                        'param page translate language has non expected language'
                    );
                } else {
                    $languageId                      = $translate->language;
                    $this->translates[$languageId()] = $translate;
                }
            }
        }

        if ($active === true) {
            if ($id === null) {
                throw new InvalidArgumentException('Page id is not set on active model');
            }
            if (count($translates) < count($languages)) {
                throw new InvalidArgumentException('Page has missing translates');
            }
        }
    }

    /** @throws CouldNotChangeActivityException */
    public function activate(): void
    {
        if ($this->active === true) {
            return;
        }

        if ($this->id === null) {
            throw new CouldNotChangeActivityException('Page id is not set');
        }

        if (count($this->languages) > count($this->translates)) {
            throw new CouldNotChangeActivityException('Page has missing translates');
        }

        foreach ($this->languages as $language) {
            $check = $this->translates[$language()] ?? null;
            if ($check === null) {
                throw new CouldNotChangeActivityException(
                    sprintf('Page has missing translates %s', $language())
                );
            }
        }

        $this->active = true;
    }

    /** @throws InvalidArgumentException */
    public function addTranslate(Translate $translate): void
    {
        $checkResult = $this->languageCheck($translate->language, $this->languages);
        if ($checkResult === false) {
            throw new InvalidArgumentException(
                'param page translate language has non expected language'
            );
        }
        $languageId                    = (string) $translate->language;
        $this->translates[$languageId] = $translate;
    }

    public function deactivate(): void
    {
        $this->active = false;
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

    /**
     * @param array<int,mixed|LanguageId> $languages
     * */
    private function languageCheck(LanguageId $id, array $languages): bool
    {
        $found = false;
        foreach ($languages as $language) {
            if ($id() === $language()) {
                $found = true;
                break;
            }
        }
        return $found;
    }
}
