<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Page;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use Romchik38\Site2\Domain\Page\Entities\Translate;
use Romchik38\Site2\Domain\Page\VO\Id;

use function array_values;
use function count;
use function sprintf;

final class Page
{
    /** @var array<int,LanguageId> $languages */
    private readonly array $languages;

    /** @var array<string,Translate> $translates */
    private array $translates = [];

    /** @todo test */
    /**
     * @param array<int,mixed|LanguageId> $languages
     * @param array<int,mixed|Translates> $translates
     * @throws InvalidArgumentException
     */
    public function __construct(
        private(set) Id $id,
        private(set) bool $active,
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
            if (count($translates) < count($languages)) {
                throw new InvalidArgumentException('Page has missing translates');
            }
        }
    }

    /** @todo test */
    /** @throws CouldNotChangeActivityException */
    public function activate(): void
    {
        if ($this->active === true) {
            return;
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

    /** @todo test */
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

    /** @todo test */
    public function deactivate(): void
    {
        $this->active = false;
    }

    /** @todo test */
    public function getTranslate(string $language): ?Translate
    {
        return $this->translates[$language] ?? null;
    }

    /** @todo test */
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
