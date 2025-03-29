<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Translate;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Translate\Entities\Phrase;
use Romchik38\Site2\Domain\Translate\VO\Identifier;

use function array_values;

final class Translate
{
    /** @var array<string,Phrase> */
    private array $phraseHash = [];

    /** @param array<int,mixed|Phrase> $phrases */
    public function __construct(
        private Identifier $identifier,
        array $phrases
    ) {
        foreach ($phrases as $phrase) {
            if (! $phrase instanceof Phrase) {
                throw new InvalidArgumentException('param phrase is not valid');
            } else {
                $this->phraseHash[(string) $phrase->getLanguage()] = $phrase;
            }
        }
    }

    public function addPhrase(Phrase $phrase): void
    {
        $this->phraseHash[(string) $phrase->getLanguage()] = $phrase;
    }

    public function getId(): Identifier
    {
        return $this->identifier;
    }

    /** @return array<int,Phrase> */
    public function getPhrases(): array
    {
        return array_values($this->phraseHash);
    }
}
