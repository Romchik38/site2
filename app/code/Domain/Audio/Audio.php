<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Audio;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Audio\Entities\Article;

/** 
 * - Audio must be *activated*.
 * - Requirements to become active:
 *   - id is set
 *   - content present in the storage (loaded)
 *   - all translates
 *   - author is active
 * - Cannot be *deactivated* when:
 *   - has references from article
 */
final class Audio
{
    /** @var array<int,Article> $articles */
    private readonly array $articles;

    /** 
     * @param array<int,mixed|Article> $articles 
     * @throws InvalidArgumentException
     * */
    private function __construct(
        private ?int $id,
        private bool $active,
        array $articles
    ) {
        foreach ($articles as $article) {
            if (! $article instanceof Article) {
                throw new InvalidArgumentException('param audio article id is invalid');
            }
            if ($article->active === true && $active === false) {
                throw new InvalidArgumentException('param audio article active and audio active are different');
            }
        }
        $this->articles = $articles;  
    }

    /** @return array<int,Article> */
    public function getArticles(): array
    {
        return $this->articles;
    }
    
    /**
     * @todo 
     * - Requirements to become active:
     *   - id is set
     *   - content present in the storage (loaded)
     *   - all translates
     *   - author is active
     * - Cannot be *deactivated* when:
     *   - has references from article
     * @throws CouldNotChangeActivityException 
     * */
    public function activate(): void
    {

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
}