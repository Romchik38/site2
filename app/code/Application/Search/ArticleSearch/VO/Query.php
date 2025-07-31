<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Search\ArticleSearch\VO;

use InvalidArgumentException;
use Romchik38\Server\Domain\VO\Text\NonEmpty;

use function explode;
use function mb_strlen;
use function preg_match;
use function preg_replace;
use function sprintf;
use function trim;

/** see docs/search/readme.md  */
final class Query extends NonEmpty
{
    const PATTERN                   = '^(?=[\p{L}\p{N}\' ]{1,255}$)(?=.*\p{L})(?!.*\'{2,})[\p{L}\p{N}\' ]+$';
    const ERROR_MESSAGE             = 'Query sting does not match given pattern';
    const ERROR_WORD_LENGTH_MESSAGE = 'Query word length exceeds the allowed value %d';
    const MAX_WORD_LENGTH           = 40;

    public function __construct(
        string $value
    ) {
        $check = preg_match($this->createPhpPattern(), $value);
        if ($check === 0 || $check === false) {
            throw new InvalidArgumentException($this::ERROR_MESSAGE);
        }
        $value = preg_replace('/\s+/', ' ', trim($value));
        if ($this->checkWordLength($value) === false) {
            throw new InvalidArgumentException(sprintf(
                $this::ERROR_WORD_LENGTH_MESSAGE,
                $this::MAX_WORD_LENGTH
            ));
        }
        parent::__construct($value);
    }

    private function checkWordLength(string $value): bool
    {
        foreach (explode(' ', $value) as $word) {
            if (mb_strlen($word) > $this::MAX_WORD_LENGTH) {
                return false;
            }
        }
        return true;
    }

    private function createPhpPattern(): string
    {
        return '/' . $this::PATTERN . '/u';
    }
}
