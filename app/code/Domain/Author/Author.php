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
    private array $translates = [];

    /**
     * @param array<int,ArticleId> - R 
     * @param array<int,ImageId> - R
     * @param array<int,LanguageId> $languages - R
     * @param array<int,Translate> $translates - RW
     * @throws InvalidArgumentException
     * */
    protected function __construct(
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
                    $this->translates[] = $translate;
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
}
