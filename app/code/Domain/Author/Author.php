<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Author;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Author\VO\Name;
use Romchik38\Site2\Domain\Article\VO\ArticleId;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;
use Romchik38\Site2\Domain\Author\Entities\Translate;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class Author
{
    /** @var array<string,Translate> */
    private array $translatesHash = [];

    /**
     * @param array<int,ArticleId> $articles
     * @param array<int,ImageId> $images
     * @param array<int,LanguageId> $languages
     * @param array<int,Translate> $translates
     * @throws InvalidArgumentException
     * */
    private function __construct(
        private AuthorId|null $identifier,
        private Name $name,
        private bool $active,
        private array $articles,
        private array $images,
        private array $languages,
        array $translates
    ) {
        // check language array
        foreach ($languages as $language) {
            if (! $language instanceof LanguageId) {
                throw new InvalidArgumentException('param language is not valid');
            }
        }
        // check article array
        foreach ($articles as $article) {
            if (! $article instanceof ArticleId) {
                throw new InvalidArgumentException('param article is not valid');
            }
        }

        // check article array
        foreach ($images as $image) {
            if (! $image instanceof ImageId) {
                throw new InvalidArgumentException('param image is not valid');
            }
        }

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

    /**
     * @param array<int,ArticleId> $articles
     * @param array<int,ImageId> $images
     * @param array<int,LanguageId> $languages
     * @param array<int,Translate> $translates
     * @throws InvalidArgumentException
     * */
    public static function load(
        AuthorId $id,
        Name $name, 
        bool $active,
        array $articles,
        array $images,
        array $languages,
        array $translates
    ): self
    {
        return new self(
            $id,
            $name,
            $active,
            $articles,
            $images,
            $languages,
            $translates
        );
    }

    public function addTranslate(Translate $translate): void
    {
        $this->translatesHash[$translate->getLanguage()] = $translate;
    }

    /** @throws CouldNotRemoveTranslateException */
    public function removeTranslate(LanguageId $language): void
    {
        if ($this->active === true) {
            throw new CouldNotRemoveTranslateException('Author is active. Deactivate first.');
        }
        $newHash = [];
        foreach ($this->translatesHash as $key => $value) {
            if ($key === $language()) {
                continue;
            }
            $newHash[$key] = $value;
        }
        $this->translatesHash = $newHash;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function reName(Name $name): void
    {
        $this->name = $name;
    }

    /** @throws CouldNotActivateException */
    public function activate(): void
    {
        if ($this->active === true) {
            return;
        }

        if ($this->identifier === null) {
            throw new CouldNotActivateException('Author id is invalid');
        }

        if (count($this->languages) !== count($this->translatesHash)) {
            throw new CouldNotActivateException('Author has missing translates');
        }
        
        foreach($this->languages as $language) {
            $check = $this->translatesHash[$language()] ?? null;
            if ($check === null) {
                throw new CouldNotActivateException(
                    sprintf('Author has missing translates %s', $language())
                );
            }
        }
        $this->active = true;
    }
}
