<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\Article;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Api\Models\SearchCriteria\SearchCriteriaInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Domain\Article\Article;
use Romchik38\Site2\Domain\Article\ArticleCategory;
use Romchik38\Site2\Domain\Article\ArticleRepositoryInterface;
use Romchik38\Site2\Domain\Article\ArticleTranslates;
use Romchik38\Site2\Domain\Article\VO\ArticleId;

/**
 * Manage article entities.
 * Makes join.
 * 
 * @todo create an interface
 * @api
 */
final class ArticleRepository implements ArticleRepositoryInterface
{
    /** Article */
    final const ARTICLE_T = 'article';
    final const ARTICLE_C_IDENTIFIER = 'identifier';
    final const ARTICLE_C_ACTIVE = 'active';

    /** Category */
    final const ARTICLE_CATEGORY_T = 'article_category';
    final const ARTICLE_CATEGORY_C_ARTICLE_ID = 'article_id';
    final const ARTICLE_CATEGORY_C_CATEGORY_ID = 'category_id';

    /** Translates */
    final const ARTICLE_TRANSLATES_T = 'article_translates';
    final const ARTICLE_TRANSLATES_C_ARTICLE_ID = 'article_id';
    final const ARTICLE_TRANSLATES_C_LANGUAGE = 'language';
    final const ARTICLE_TRANSLATES_C_NAME = 'name';
    final const ARTICLE_TRANSLATES_C_SHORT_DESCRIPTION = 'short_description';
    final const ARTICLE_TRANSLATES_C_DESCRIPTION = 'description';
    final const ARTICLE_TRANSLATES_C_CREATED_AT = 'created_at';
    final const ARTICLE_TRANSLATES_C_UPDATED_AT = 'updated_at';

    /** @var array<string,Article> $hash */
    protected $hash = [];

    public function __construct(
        protected DatabaseInterface $database
    ) {}

    public function getById(ArticleId $id): Article
    {
        /** 1 check the hash */
        $hashed = $this->hash[$id->toString()] ?? null;
        if ($hashed !== null) {
            return $hashed;
        }

        $expression = sprintf(
            'WHERE %s.%s = $1',
            $this::ARTICLE_T,
            $this::ARTICLE_C_IDENTIFIER
        );

        /** 2. Entity rows */
        $rows = $this->listRows(
            [sprintf('%s.*', $this::ARTICLE_T)],
            [$this::ARTICLE_T],
            $expression,
            [$id->toString()]
        );

        if (count($rows) === 0) {
            throw new NoSuchEntityException(
                sprintf('Article with id %s not exist', $id->toString())
            );
        }

        /** 3. Create an Entity */
        $article = $this->createSingleArticleFromRows($rows);

        /** 4. Add to hash */
        $this->hash[$id->toString()] = $article;

        return $article;
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
        $paramCount = 0;

        /** WHERE */
        $filter = $searchCriteria->getFilter();
        if ($filter !== null){
            $expression[] = sprintf(
                'WHERE %s',
                $filter->getExpression((string)++$paramCount)
            );
            $params[] = $filter->getParam();
        }

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

        /** LIMIT */
        $limit = $searchCriteria->limit();
        $expression[] = sprintf('LIMIT $%s', ++$paramCount);
        $params[] = $limit->toString();
        
        /** OFFSET */
        $offset = $searchCriteria->offset();
        $expression[] = sprintf('OFFSET $%s', ++$paramCount);
        $params[] = $offset->toString();

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
            $result[] = $this->getById(
                new ArticleId($row[$entityIdFieldName])
            );
        }

        return $result;
    }

    /**
     * SELECT
     * Create an Article entity from rows with the same article id
     * @param array<int,array<string,string>> $rows
     */
    protected function createSingleArticleFromRows(array $rows): Article
    {
        // 1. create translates
        $translates = $this->createTranslatesFromRows($rows);
        $categories = $this->createCategoriesFromRows($rows);

        // 2. create an entity
        $firstRow = $rows[0];
        $entity = new Article(
            new ArticleId($firstRow[$this::ARTICLE_C_IDENTIFIER]),
            $firstRow[$this::ARTICLE_C_ACTIVE] === 'f' ? false : true,
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
     * @return array<string,ArticleTranslates> a hash [language => ArticleTranslates, ...] 
     * */
    protected function createTranslatesFromRows(array $articleRows): array
    {
        $translates = [];
        if (count($articleRows) === 0) {
            return $translates;
        }

        /** 1 make a select request */
        $firstRow = $articleRows[0];
        $articleId = $firstRow[$this::ARTICLE_C_IDENTIFIER] ?? null;
        if ($articleId === null) {
            return $translates;
        }
        $articleTranslatesArticleId = sprintf(
            '%s.%s',
            $this::ARTICLE_TRANSLATES_T,
            $this::ARTICLE_TRANSLATES_C_ARTICLE_ID
        );
        $expression = sprintf('WHERE %s = $1', $articleTranslatesArticleId);
        $params = [$articleId];
        $rows = $this->listRows(
            [
                $articleTranslatesArticleId,
                sprintf(
                    '%s.%s',
                    $this::ARTICLE_TRANSLATES_T,
                    $this::ARTICLE_TRANSLATES_C_LANGUAGE
                ),
                sprintf(
                    '%s.%s',
                    $this::ARTICLE_TRANSLATES_T,
                    $this::ARTICLE_TRANSLATES_C_NAME
                ),
                sprintf(
                    '%s.%s',
                    $this::ARTICLE_TRANSLATES_T,
                    $this::ARTICLE_TRANSLATES_C_SHORT_DESCRIPTION
                ),
                sprintf(
                    '%s.%s',
                    $this::ARTICLE_TRANSLATES_T,
                    $this::ARTICLE_TRANSLATES_C_DESCRIPTION
                ),
                sprintf(
                    '%s.%s',
                    $this::ARTICLE_TRANSLATES_T,
                    $this::ARTICLE_TRANSLATES_C_CREATED_AT
                ),
                sprintf(
                    '%s.%s',
                    $this::ARTICLE_TRANSLATES_T,
                    $this::ARTICLE_TRANSLATES_C_UPDATED_AT
                )
            ],
            [
                $this::ARTICLE_TRANSLATES_T
            ],
            $expression,
            $params
        );

        /** 2 create and entities */
        foreach ($rows as $row) {
            $language = $row[$this::ARTICLE_TRANSLATES_C_LANGUAGE];
            $item = $translates[$language] ?? new ArticleTranslates(
                $row[$this::ARTICLE_TRANSLATES_C_ARTICLE_ID],
                $language,
                $row[$this::ARTICLE_TRANSLATES_C_NAME],
                $row[$this::ARTICLE_TRANSLATES_C_SHORT_DESCRIPTION],
                $row[$this::ARTICLE_TRANSLATES_C_DESCRIPTION],
                new \DateTime($row[$this::ARTICLE_TRANSLATES_C_CREATED_AT]),
                new \DateTime($row[$this::ARTICLE_TRANSLATES_C_UPDATED_AT])
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
        $articleId = $firstRow[$this::ARTICLE_C_IDENTIFIER] ?? null;
        if ($articleId === null) {
            return $categories;
        }

        $articleCategoryArticleId = sprintf(
            '%s.%s',
            $this::ARTICLE_CATEGORY_T,
            $this::ARTICLE_CATEGORY_C_ARTICLE_ID
        );
        $expression = sprintf('WHERE %s = $1', $articleCategoryArticleId);
        $params = [$articleId];
        $rows = $this->listRows(
            [
                $articleCategoryArticleId,
                sprintf(
                    '%s.%s',
                    $this::ARTICLE_CATEGORY_T,
                    $this::ARTICLE_CATEGORY_C_CATEGORY_ID
                ),
            ],
            [
                $this::ARTICLE_CATEGORY_T
            ],
            $expression,
            $params
        );

        foreach ($rows as $row) {
            $categoryId = $row[$this::ARTICLE_CATEGORY_C_CATEGORY_ID];
            $item = $categories[$categoryId] ?? new ArticleCategory(
                $row[$this::ARTICLE_CATEGORY_C_ARTICLE_ID],
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
