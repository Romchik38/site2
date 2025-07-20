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

        // check traslates array
        foreach ($translates as $translate) {
            if (! $translate instanceof Translate) {
                throw new InvalidArgumentException('param translate is not valid');
            }
        }

        if (count($languages) === 0) {
            throw new InvalidArgumentException('Languages list is empty');
        }
        if (count($languages) < count($translates)) {
            throw new InvalidArgumentException('Translates count can not be grater than languages');
        }
        foreach ($translates as $translate) {
            foreach ($languages as $languageId) {
                $translateLanguageId = $translate->getLanguage();
                if ($translateLanguageId() === $languageId()) {
                    $this->translatesHash[$translateLanguageId()] = $translate;
                    break;
                }
            }
        }
    }

    /**
     * @param array<int,LanguageId> $languages
     * @throws InvalidArgumentException
     * */
    public static function createNew(Name $name, array $languages): self
    {
        return new self(
            null,
            $name,
            false,
            [],
            [],
            $languages,
            []
        );
    }

    public function addTranslate(Translate $translate): void
    {
        $this->translatesHash[(string) $translate->getLanguage()] = $translate;
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
            throw new CouldNotChangeActivityException('Author id is invalid');
        }

        if (count($this->languages) !== count($this->translatesHash)) {
            throw new CouldNotChangeActivityException('Author has missing translates');
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
            throw new CouldNotChangeActivityException('Author is used in articles. Change it first');
        }

        if (count($this->images) > 0) {
            throw new CouldNotChangeActivityException('Author is used in images. Change it first');
        }

        $this->active = false;
    }
}
