<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\Virtual\Article\Sql;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Server\Models\Sql\Virtual\VirtualRepository;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleFactoryInterface;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleInterface;

/**
 * Manage article entities.
 * Makes join.
 * 
 * @todo create an interface
 * @api
 */
final class ArticleRepository extends VirtualRepository
{
    /**
     * 
     * @param string[] $primaryIds The Article's identifiers from all tables with tables names
     */
    public function __construct(
        protected DatabaseInterface $database,
        protected ArticleFactoryInterface $modelFactory,
        protected readonly array $selectFields,
        protected readonly array $tables,
        protected readonly array $primaryIds
    ) {
        /** this is a join table so minimum two field needed to make an equal */
        if (count($primaryIds) < 2) {
            throw new InvalidArgumentException(
                'Expect at least two values in the array of $primaryIds param'
            );
        }
    }

    /** 
     * @todo move to intyerface
     * 
     * @param string $id An entity id. Will be compared with first value in the $primaryIds array
     * @throws NoSuchEntityException
     * @return ArticleInterface An article entity
     */
    public function getById(string $id): ArticleInterface
    {
        $firstPrimaryId = $this->primaryIds[0];
        $parts = [];
        $count = count($this->primaryIds);
        for ($i = 1; $i < $count; $i++) {
            $parts[] = sprintf('%s = %s', $firstPrimaryId, $this->primaryIds[$i]);
        }
        $expression = sprintf(
            'WHERE %s = $1 AND %s',
            $firstPrimaryId,
            implode(' AND ', $parts)
        );

        /** @var ArticleInterface[]  $models */
        $models = $this->list($expression, [$id]);
        if (count($models) === 0) {
            throw new NoSuchEntityException(
                sprintf('Article with id %s not exist', $id)
            );
        }

        return $models[0];
    }
}
