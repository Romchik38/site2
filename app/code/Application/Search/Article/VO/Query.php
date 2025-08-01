<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Search\Article\VO;

use InvalidArgumentException;
use Romchik38\Server\Domain\VO\Text\NonEmpty;
use RuntimeException;

use function explode;
use function mb_strlen;
use function preg_match;
use function preg_replace;
use function sprintf;
use function str_starts_with;
use function trim;

/** see docs/search/readme.md  */
final class Query extends NonEmpty
{
    public const PATTERN =
        '^(?=[\p{L}\p{N}\'’` ]{1,255}$)(?=.*\p{L})(?!.*\'{2,})(?!.*ʼ{2,})(?!.*`.*`)[\p{L}\p{N}\'’` ]+$';

    public const ERROR_MESSAGE             = 'Query sting does not match given pattern';
    public const ERROR_WORD_LENGTH_MESSAGE = 'Query word length exceeds the allowed value %d';
    public const ERROR_WORD_STARTS_MESSAGE = 'Query word could not starts with apostrophe';
    public const MAX_WORD_LENGTH           = 40;

    /**
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function __construct(
        string $value
    ) {
        $check = preg_match($this->createPhpPattern(), $value);
        if ($check === 0 || $check === false) {
            throw new InvalidArgumentException($this::ERROR_MESSAGE);
        }
        $value = preg_replace('/\s+/', ' ', trim($value));
        if ($value === null) {
            throw new RuntimeException('Could not proccess space replace of the query');
        }

        $this->checkWords($value);

        parent::__construct($value);
    }

    private function checkWords(string $value): void
    {
        foreach (explode(' ', $value) as $word) {
            // Check length
            if (mb_strlen($word) > $this::MAX_WORD_LENGTH) {
                throw new InvalidArgumentException(sprintf(
                    $this::ERROR_WORD_LENGTH_MESSAGE,
                    $this::MAX_WORD_LENGTH
                ));
            }
            // Check starts
            if (
                str_starts_with($word, '`') ||
                str_starts_with($word, 'ʼ') ||
                str_starts_with($word, '\'')
            ) {
                throw new InvalidArgumentException($this::ERROR_WORD_STARTS_MESSAGE);
            }
        }
    }

    private function createPhpPattern(): string
    {
        return '/' . $this::PATTERN . '/u';
    }
}
