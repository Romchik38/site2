<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\Virtual\Article\Sql;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Api\Models\ArticleCategory\ArticleCategoryFactoryInterface;
use Romchik38\Site2\Api\Models\ArticleCategory\ArticleCategoryInterface;
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
    /** SELECT FIELDS */
    protected const T_ARTICLE_C_IDENTIFIER = 'article.identifier';
    protected const T_ARTICLE_C_ACTIVE = 'article.active';

    protected const T_ARTICLE_TRANSLATES_C_ARTICLE_ID = 'article_translates.article_id';
    protected const T_ARTICLE_TRANSLATES_C_LANGUAGE = 'article_translates.language';
    protected const T_ARTICLE_TRANSLATES_C_NAME = 'article_translates.name';
    protected const T_ARTICLE_TRANSLATES_C_SHORT_DESCRIPTION = 'article_translates.short_description';
    protected const T_ARTICLE_TRANSLATES_C_DESCRIPTION = 'article_translates.description';
    protected const T_ARTICLE_TRANSLATES_C_CREATED_AT = 'article_translates.created_at';
    protected const T_ARTICLE_TRANSLATES_C_UPDATED_AT = 'article_translates.updated_at';

    protected const T_ARTICLE_CATEGORY_C_ARTICLE_ID = 'article_category.article_id';
    protected const T_ARTICLE_CATEGORY_C_CATEGORY_ID = 'article_category.category_id';

    /** TABLES */
    protected const T_ARTICLE = 'article';
    protected const T_ARTICLE_TRANSLATES = 'article_translates';
    protected const T_ARTICLE_CATEGORY = 'article_category';

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
        protected readonly ArticleTranslatesFactoryInterface $articleTranslatesFactory,
        protected readonly ArticleCategoryFactoryInterface $articleCategoryFactory
    ) {}

    /** 
     * @todo move to interface
     * 
     * @param string $id An entity id. Will be compared with first value in the $primaryIds array
     * @throws NoSuchEntityException
     * @return ArticleInterface An article entity
     */
    public function getById(string $id): ArticleInterface
    {
        $expression = sprintf('WHERE %s = $1', $this::T_ARTICLE_C_IDENTIFIER);

        /** 1. Entity rows */
        $rows = $this->listRows(
            [$this::T_ARTICLE_C_IDENTIFIER, $this::T_ARTICLE_C_ACTIVE],
            [$this::T_ARTICLE],
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

    /**
     * Create an Article entity from rows with the same article id
     * 
     * @todo check param $rows has this structure 
     *                  \/
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

    /** @return array<string,ArticleTranslatesInterface> a hash [language => ArticleTranslatesInterface, ...] */
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
        $expression = sprintf('WHERE %s = $1', $this::T_ARTICLE_TRANSLATES_C_ARTICLE_ID);
        $params = [$articleId];
        $rows = $this->listRows(
            [
                $this::T_ARTICLE_TRANSLATES_C_ARTICLE_ID,
                $this::T_ARTICLE_TRANSLATES_C_LANGUAGE,
                $this::T_ARTICLE_TRANSLATES_C_NAME,
                $this::T_ARTICLE_TRANSLATES_C_SHORT_DESCRIPTION,
                $this::T_ARTICLE_TRANSLATES_C_DESCRIPTION,
                $this::T_ARTICLE_TRANSLATES_C_CREATED_AT,
                $this::T_ARTICLE_TRANSLATES_C_UPDATED_AT
            ],
            [
                $this::T_ARTICLE_TRANSLATES
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

    /** @todo refactor like createTranslatesFromRows */
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

        $expression = sprintf('WHERE %s = $1', $this::T_ARTICLE_CATEGORY_C_ARTICLE_ID);
        $params = [$articleId];
        $rows = $this->listRows(
            [
                $this::T_ARTICLE_CATEGORY_C_ARTICLE_ID,
                $this::T_ARTICLE_CATEGORY_C_CATEGORY_ID,
            ],
            [
                $this::T_ARTICLE_CATEGORY
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
     * COMMON
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
