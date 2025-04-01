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
use Romchik38\Site2\Domain\Image\Entities\Translate;

final class Image
{
    /** @var array<int,ArticleId> $articles */
    private readonly array $articles;

    /** @var string $data Image content */
    private string $data;

    /** @todo implement */
    private bool $isLoaded = false;

    /** @var array<int,LanguageId> $languages */
    private readonly array $languages;

    /** @var array<string,Translate> $translates */
    private array $translates = [];

    /** @todo implement */
    private ?string $type = null;

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
                $languageId = $translate->getLanguage();
                $this->translates[$languageId()] = $translate;
            }
        }
    }

    public function load(string $data, string $type): void
    {
        $this->data     = $data;
        $this->type     = $type;
        $this->isLoaded = true;
    }

    public function isLoaded(): bool
    {
        return $this->isLoaded;
    }
}
