<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Author;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Author\Entities\Translate;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Name;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

use function array_values;
use function count;
use function sprintf;

final class Author
{
    public const INVALID_LANGUAGE    = 'param author translate language has non expected language';
    public const INVALID_ID          = 'Author id is invalid';
    public const MISSING_TRANSLATE   = 'Author has missing translates';
    public const DEACTIVATE_ARTICLES = 'Author is used in articles. Change it first';
    public const DEACTIVATE_IMAGES   = 'Author is used in images. Change it first';

    /** @var array<string,Translate> */
    private array $translatesHash = [];

    /** @var array<int,ArticleId> $articles */
    private readonly array $articles;

    /** @var array<int,ImageId> $images */
    private readonly array $images;

    /** @var array<int,LanguageId> $languages */
    private readonly array $languages;

    /**
     * @param array<int,mixed|ArticleId> $articles
     * @param array<int,mixed|ImageId> $images
     * @param array<int,mixed|LanguageId> $languages
     * @param array<int,mixed|Translate> $translates
     * @throws InvalidArgumentException
     * */
    public function __construct(
        public readonly AuthorId|null $identifier,
        public Name $name,
        private(set) bool $active,
        array $articles,
        array $images,
        array $languages,
        array $translates
    ) {
        // check language array
        foreach ($languages as $language) {
            if (! $language instanceof LanguageId) {
                throw new InvalidArgumentException('param language is not valid');
            }
        }
        $this->languages = $languages;
        // check article array
        foreach ($articles as $article) {
            if (! $article instanceof ArticleId) {
                throw new InvalidArgumentException('param article is not valid');
            }
        }
        $this->articles = $articles;

        // check article array
        foreach ($images as $image) {
            if (! $image instanceof ImageId) {
                throw new InvalidArgumentException('param image is not valid');
            }
        }
        $this->images = $images;

        if (count($languages) === 0) {
            throw new InvalidArgumentException('param author languages list is empty');
        }
        if (count($languages) < count($translates)) {
            throw new InvalidArgumentException('Translates count can not be grater than languages');
        }
        // check traslates array
        foreach ($translates as $translate) {
            if (! $translate instanceof Translate) {
                throw new InvalidArgumentException('param author translate is invalid');
            }
            $this->languageCheck($translate, $languages);
            $languageId                          = $translate->language;
            $this->translatesHash[$languageId()] = $translate;
        }

        if ($active) {
            if ($identifier === null) {
                throw new InvalidArgumentException($this::INVALID_ID);
            }
        }
    }

    /**
     * @param array<int,LanguageId> $languages
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
            $name,
            false,
            [],
            [],
            $languages,
            $translates
        );
    }

    /** @throws InvalidArgumentException */
    public function addTranslate(Translate $translate): void
    {
        $this->languageCheck($translate, $this->languages);
        $key                        = (string) $translate->getLanguage();
        $this->translatesHash[$key] = $translate;
    }

    /** @return array<int,Translate> */
    public function getTranslates(): array
    {
        return array_values($this->translatesHash);
    }

    public function getName(): Name
    {
        return $this->name;
    }

    /** @throws CouldNotChangeActivityException */
    public function activate(): void
    {
        if ($this->active === true) {
            return;
        }

        if ($this->identifier === null) {
            throw new CouldNotChangeActivityException($this::INVALID_ID);
        }

        if (count($this->languages) !== count($this->translatesHash)) {
            throw new CouldNotChangeActivityException($this::MISSING_TRANSLATE);
        }

        foreach ($this->languages as $language) {
            $check = $this->translatesHash[$language()] ?? null;
            if ($check === null) {
                throw new CouldNotChangeActivityException(
                    sprintf('Author has missing translates %s', $language())
                );
            }
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
            throw new CouldNotChangeActivityException($this::DEACTIVATE_ARTICLES);
        }

        if (count($this->images) > 0) {
            throw new CouldNotChangeActivityException($this::DEACTIVATE_IMAGES);
        }

        $this->active = false;
    }

    /**
     * @param array<int,mixed|LanguageId> $languages
     * @throws InvalidArgumentException
     * */
    private function languageCheck(Translate $translate, array $languages): void
    {
        $languageId = $translate->language;
        $found      = false;
        foreach ($languages as $language) {
            if ($languageId() === $language()) {
                $found = true;
                break;
            }
        }
        if (! $found) {
            throw new InvalidArgumentException($this::INVALID_LANGUAGE);
        }
    }
}
