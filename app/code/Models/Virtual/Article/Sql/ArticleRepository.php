<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\Virtual\Article\Sql;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Api\Models\SearchCriteria\SearchCriteriaInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Api\Models\ArticleCategory\ArticleCategoryFactoryInterface;
use Romchik38\Site2\Api\Models\ArticleCategory\ArticleCategoryInterface;
use Romchik38\Site2\Api\Models\ArticleTranslates\ArticleTranslatesFactoryInterface;
use Romchik38\Site2\Api\Models\ArticleTranslates\ArticleTranslatesInterface;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleFactoryInterface;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleInterface;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleRepositoryInterface;

/**
 * Manage article entities.
 * Makes join.
 * 
 * @todo create an interface
 * @api
 */
final class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     * 
     * @param string[] $primaryIds The Article's identifiers from all tables with tables names
     */
    public function __construct(
        protected DatabaseInterface $database,
        protected ArticleFactoryInterface $articleFactory,
        /** @todo refactor this */
        protected array $selectFields,
        protected array $tables,
        protected readonly array $primaryIds,
        protected readonly ArticleTranslatesFactoryInterface $articleTranslatesFactory,
        protected readonly ArticleCategoryFactoryInterface $articleCategoryFactory
    ) {}

    public function getById(string $id): ArticleInterface
    {
        $expression = sprintf('WHERE %s = $1', ArticleInterface::ID_FIELD);

        /** 1. Entity rows */
        $rows = $this->listRows(
            [sprintf('%s.*', ArticleInterface::ENTITY_NAME)],
            [ArticleInterface::ENTITY_NAME],
            $expression,
            [$id]
        );

        if (count($rows) === 0) {
            throw new NoSuchEntityException(
                sprintf('Article with id %s not exist', $id)
            );
        }

        /** 2. Create an Entity */
        $model = $this->createSingleArticleFromRows($rows);

        return $model;
    }

    public function list(SearchCriteriaInterface $searchCriteria): array
    {
        $entityIdFieldName = $searchCriteria->getEntityIdFieldName();
        $selectedFields = [
            sprintf(
                '%s.%s',
                $searchCriteria->getTableName(),
                $entityIdFieldName
            )
        ];
        $selectedTables = [$searchCriteria->getTableName()];

        $expression = [];
        $params = [];

        /** WHERE */

        /** ORDER BY */
        $orderBy = $searchCriteria->getAllOrderBy();
        $orders = [];
        foreach ($orderBy as $item) {
            $orderLine = sprintf(
                '%s %s %s',
                $item->getField(),
                $item->getDirection(),
                $item->getNulls()
            );
            $orders[] = $orderLine;
        }
        if (count($orders) > 0) {
            $expression[] = sprintf(
                'ORDER BY %s',
                implode(', ', $orders)
            );
        }

        /** get rows */
        $rows = $this->listRows(
            $selectedFields,
            $selectedTables,
            implode(' ', $expression),
            $params
        );

        /** create entities */
        $result = [];
        foreach ($rows as $row) {
            $result[] = $this->getById($row[$entityIdFieldName]);
        }

        return $result;
    }

    /**
     * SELECT
     * Create an Article entity from rows with the same article id
     * @param array<int,array<string,string>> $rows
     */
    protected function createSingleArticleFromRows(array $rows): ArticleInterface
    {
        // 1. create translates
        $translates = $this->createTranslatesFromRows($rows);
        $categories = $this->createCategoriesFromRows($rows);

        // 2. create an entity
        $firstRow = $rows[0];
        $entity = $this->articleFactory->create(
            $firstRow[ArticleInterface::ID_FIELD],
            $firstRow[ArticleInterface::ACTIVE_FIELD] === 'f' ? false : true,
            $translates,
            $categories
        );

        return $entity;
    }

    /**
     * SELECT
     * Create all translates for one Model
     * 
     * @param array<int,array<string,string>> $articleRows rows of a single model, all article ids must be the same
     * @return array<string,ArticleTranslatesInterface> a hash [language => ArticleTranslatesInterface, ...] 
     * */
    protected function createTranslatesFromRows(array $articleRows): array
    {
        $translates = [];
        if (count($articleRows) === 0) {
            return $translates;
        }

        /** 1 make a select request */
        $firstRow = $articleRows[0];
        $articleId = $firstRow[ArticleInterface::ID_FIELD] ?? null;
        if ($articleId === null) {
            return $translates;
        }
        $articleTranslatesArticleId = sprintf(
            '%s.%s',
            ArticleTranslatesInterface::ENTITY_NAME,
            ArticleTranslatesInterface::ARTICLE_ID_FIELD
        );
        $expression = sprintf('WHERE %s = $1', $articleTranslatesArticleId);
        $params = [$articleId];
        $rows = $this->listRows(
            [
                $articleTranslatesArticleId,
                sprintf(
                    '%s.%s',
                    ArticleTranslatesInterface::ENTITY_NAME,
                    ArticleTranslatesInterface::LANGUAGE_FIELD
                ),
                sprintf(
                    '%s.%s',
                    ArticleTranslatesInterface::ENTITY_NAME,
                    ArticleTranslatesInterface::NAME_FIELD
                ),
                sprintf(
                    '%s.%s',
                    ArticleTranslatesInterface::ENTITY_NAME,
                    ArticleTranslatesInterface::SHORT_DESCRIPTION_FIELD
                ),
                sprintf(
                    '%s.%s',
                    ArticleTranslatesInterface::ENTITY_NAME,
                    ArticleTranslatesInterface::DESCRIPTION_FIELD
                ),
                sprintf(
                    '%s.%s',
                    ArticleTranslatesInterface::ENTITY_NAME,
                    ArticleTranslatesInterface::CREATED_AT_FIELD
                ),
                sprintf(
                    '%s.%s',
                    ArticleTranslatesInterface::ENTITY_NAME,
                    ArticleTranslatesInterface::UPDATED_AT_FIELD
                )
            ],
            [
                ArticleTranslatesInterface::ENTITY_NAME
            ],
            $expression,
            $params
        );

        /** 2 create and entities */
        foreach ($rows as $row) {
            $language = $row[ArticleTranslatesInterface::LANGUAGE_FIELD];
            $item = $translates[$language] ?? $this->articleTranslatesFactory->create(
                $row[ArticleTranslatesInterface::ARTICLE_ID_FIELD],
                $language,
                $row[ArticleTranslatesInterface::NAME_FIELD],
                $row[ArticleTranslatesInterface::SHORT_DESCRIPTION_FIELD],
                $row[ArticleTranslatesInterface::DESCRIPTION_FIELD],
                new \DateTime($row[ArticleTranslatesInterface::CREATED_AT_FIELD]),
                new \DateTime($row[ArticleTranslatesInterface::UPDATED_AT_FIELD])
            );
            $translates[$language] = $item;
        }

        return $translates;
    }

    /**
     * SELECT
     * Create all categories for one Model
     * 
     * @param array<int,array<string,string>> $articleRows rows of a single model, all article ids must be the same
     * @return array<string,ArticleCategoryInterface> a hash [category_id => ArticleCategoryInterface, ...] 
     * */
    protected function createCategoriesFromRows(array $articleRows): array
    {
        $categories = [];
        if (count($articleRows) === 0) {
            return $categories;
        }

        /** 1 make a select request */
        $firstRow = $articleRows[0];
        $articleId = $firstRow[ArticleInterface::ID_FIELD] ?? null;
        if ($articleId === null) {
            return $categories;
        }

        $articleCategoryArticleId = sprintf(
            '%s.%s', 
            ArticleCategoryInterface::ENTITY_NAME,
            ArticleCategoryInterface::ARTICLE_ID_FIELD
        );
        $expression = sprintf('WHERE %s = $1', $articleCategoryArticleId);
        $params = [$articleId];
        $rows = $this->listRows(
            [
                $articleCategoryArticleId,
                sprintf(
                    '%s.%s',
                    ArticleCategoryInterface::ENTITY_NAME,
                    ArticleCategoryInterface::CATEGORY_ID_FIELD
                ),
            ],
            [
                ArticleCategoryInterface::ENTITY_NAME
            ],
            $expression,
            $params
        );


        foreach ($rows as $row) {
            $categoryId = $row[ArticleCategoryInterface::CATEGORY_ID_FIELD];
            $item = $categories[$categoryId] ?? $this->articleCategoryFactory->create(
                $row[ArticleCategoryInterface::ARTICLE_ID_FIELD],
                $categoryId,
            );
            $categories[$categoryId] = $item;
        }
        return $categories;
    }

    /**
     * SELECT
     * used to select rows from all tables by given expression
     */
    protected function listRows(
        array $selectedFields,
        array $selectedTables,
        string $expression,
        array $params
    ): array {

        $query = 'SELECT ' . implode(', ', $selectedFields)
            . ' FROM ' . implode(', ', $selectedTables) . ' ' . $expression;

        $rows = $this->database->queryParams($query, $params);

        return $rows;
    }
}
