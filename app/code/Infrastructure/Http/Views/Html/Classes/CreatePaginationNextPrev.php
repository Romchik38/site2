<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Views\Html\Classes;

use InvalidArgumentException;
use Romchik38\Site2\Infrastructure\Http\Views\Html\CreatePaginationInterface;
use Romchik38\Site2\Infrastructure\Http\Views\Html\UrlGeneratorInterface;

use function array_merge;
use function htmlspecialchars;
use function sprintf;

/**
 * It is responsable for creating HTML pagination block
 * */
final class CreatePaginationNextPrev implements CreatePaginationInterface
{
    /** @var array<int,Query> */
    private array $queries;

    /**
     * @param array<int,mixed|Query> $queries
     * @throws InvalidArgumentException
     * */
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly int $displayed,
        private readonly int $page,
        private readonly string $pageFieldName,
        private readonly int $totalCount,
        private readonly int $limit,
        array $queries = [],
        private readonly string $labelNext = 'Next',
        private readonly string $labelPrev = 'Prev',
    ) {
        if ($displayed < 0) {
            throw new InvalidArgumentException(sprintf('Pagination param displayed %s is invalid', $displayed));
        }
        if ($page < 0) {
            throw new InvalidArgumentException(sprintf('Pagination param page %s is invalid', $page));
        }
        if ($totalCount < 0) {
            throw new InvalidArgumentException(sprintf('Pagination param totalCount %d is invalid', $totalCount));
        }
        foreach ($queries as $query) {
            if (! $query instanceof Query) {
                throw new InvalidArgumentException('Parm query is invalid');
            }
        }
        $this->queries = $queries;
    }

    public function create(): string
    {
        // Case 1: do not show pagination
        if ($this->displayed === $this->totalCount) {
            return '';
        }

        if ($this->page === 1) {
            $visited = $this->displayed;
        } else {
            $visited = ($this->page - 1) * $this->limit + $this->displayed;
        }

        $container = '<div class="text-center">%s%s</div>';
        $next      = '';
        $prev      = '';

        if ($visited < $this->totalCount) {
            $next = $this->link($this->page + 1, sprintf('%s >', $this->labelNext));
        }
        if ($this->page > 1) {
            $prev = $this->link($this->page - 1, sprintf('< %s', $this->labelPrev));
        }

        return sprintf($container, $prev, $next);
    }

    private function link(int $pageNumber, string $innerText): string
    {
        $link = $this->glueLink((string) $pageNumber);
        return sprintf(
            '<a class="btn btn-secondary mx-2" href="%s">%s</a>',
            htmlspecialchars($link),
            $innerText
        );
    }

    private function glueLink(string $part): string
    {
        $queryArr = array_merge(
            [
                new Query($this->pageFieldName, $part),
            ],
            $this->queries
        );
        return $this->urlGenerator->generateUrl($queryArr);
    }
}
