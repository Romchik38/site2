<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminArticleListView\VO;

use InvalidArgumentException;

final class Page
{
    public const DEFAULT_PAGE = 1;

    public function __construct(
        public readonly int $page
    ) {
        if($page <= 0) {
            throw new InvalidArgumentException(
                sprintf('param page %s is invalid', $page)
            );
        }
    }

    public static function fromString(string $page): self
    {
        if ($page === '') {
            return new self(self::DEFAULT_PAGE);
        } else {
            $intPage = (int)$page;
            $strPage = (string) $intPage;
            if($page !== $strPage) {
                throw new InvalidArgumentException(
                    sprintf('param page %s is invalid', $page)
                );
            }
            return new self($intPage);
        }  
    }

    public function __invoke(): int
    {
        return $this->page;
    }
}