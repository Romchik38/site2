<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\Virtual\Article\Sql;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Api\Models\ArticleTranslates\ArticleTranslatesFactoryInterface;
use Romchik38\Site2\Api\Models\ArticleTranslates\ArticleTranslatesInterface;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleFactoryInterface;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleInterface;

/**
 * Manage article entities.
 * Makes join.
 * 
 * @todo create an interface
 * @api
 */
final class ArticleRepository
{
    /**
     * 
     * @param string[] $primaryIds The Article's identifiers from all tables with tables names
     */
    public function __construct(
        protected DatabaseInterface $database,
        protected ArticleFactoryInterface $articleFactory,
        protected array $selectFields,
        protected array $tables,
        protected readonly array $primaryIds,
        protected readonly ArticleTranslatesFactoryInterface $articleTranslatesFactory
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
        $rows = $this->listRows($expression, [$id]);

        if (count($rows) === 0) {
            throw new NoSuchEntityException(
                sprintf('Article with id %s not exist', $id)
            );
        }

        // We know that there are only rows with the same article id
        $model = $this->createSingleArticleFromRows($rows);

        return $model;
    }

    /**
     * Create an Article entity from rows with the same article id
     */
    protected function createSingleArticleFromRows(array $rows): ArticleInterface
    {
        // 1. create translates
        $translates = $this->createTranslatesFromRows($rows);

        // 2. create an entity
        $row = $rows[0];
        $entity = $this->articleFactory->create(
            $row[ArticleInterface::ID_FIELD],
            (bool)$row[ArticleInterface::ACTIVE_FIELD],
            $translates
        );

        return $entity;
    }

    /** @return ArticleTranslatesInterface[] a hash [language => ArticleTranslatesInterface, ...] */
    protected function createTranslatesFromRows(array $rows): array
    {
        $translates = [];
        foreach ($rows as $row) {
            $language = $row[ArticleTranslatesInterface::LANGUAGE_FIELD];
            $item = $translates[$language] ?? $this->articleTranslatesFactory->create(
                $row[ArticleInterface::ID_FIELD],
                $row[ArticleTranslatesInterface::LANGUAGE_FIELD],
                $row[ArticleTranslatesInterface::NAME_FIELD],
                $row[ArticleTranslatesInterface::DESCRIPTION_FIELD],
                /** add DateTimeZone */
                new \DateTime($row[ArticleTranslatesInterface::CREATED_AT_FIELD]),
                new \DateTime($row[ArticleTranslatesInterface::UPDATED_AT_FIELD])
            );
            $translates[$language] = $item;
        }

        return $translates;
    }

    /**
     * used to select rows from all tables by given expression
     */
    protected function listRows(string $expression, array $params): array
    {

        $query = 'SELECT ' . implode(', ', $this->selectFields)
            . ' FROM ' . implode(', ', $this->tables) . ' ' . $expression;

        $rows = $this->database->queryParams($query, $params);

        return $rows;
    }
}
