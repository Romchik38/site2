<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleView;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Server\Models\Errors\RepositoryConsistencyException;
use Romchik38\Site2\Application\ArticleView\Find;
use Romchik38\Site2\Application\ArticleView\View\ArticleIdNameDTO;
use Romchik38\Site2\Application\ArticleView\View\ArticleViewDTO;
use Romchik38\Site2\Application\ArticleView\View\ArticleViewDTOFactory;
use Romchik38\Site2\Application\ArticleView\View\ArticleViewRepositoryInterface;
use Romchik38\Site2\Application\ArticleView\View\AudioDTOFactory;
use Romchik38\Site2\Application\ArticleView\View\AuthorDTO;
use Romchik38\Site2\Application\ArticleView\View\ImageDTOFactory;

final class ArticleViewRepository implements ArticleViewRepositoryInterface
{

    public function __construct(
        protected readonly DatabaseInterface $database,
        protected readonly ArticleViewDTOFactory $factory,
        protected readonly ImageDTOFactory $imageDTOFactory,
        protected readonly AudioDTOFactory $audioDTOFactory
    ) {}

    public function getByIdAndLanguage(Find $command): ArticleViewDTO
    {
        $articleId = $command->id();
        $language = $command->language();
        $params = [$language, $articleId];

        $rows = $this->database->queryParams($this->getByIdQuery(), $params);

        if (count($rows) === 0) {
            throw new NoSuchEntityException(sprintf(
                'Article with id %s and language %s not found',
                $articleId,
                $language
            ));
        } elseif (count($rows) > 1) {
            throw new RepositoryConsistencyException(sprintf(
                'Article with id %s and language %s has duplicate',
                $articleId,
                $language
            ));
        }

        $row = $rows[0];

        return $this->createFromRow($row);
    }

    /** @return array<int,string> */
    public function listIds(): array
    {
        $query = <<<QUERY
        SELECT article.identifier FROM article 
        WHERE article.active = 'true'
        QUERY;

        $rows = $this->database->queryParams($query, []);
        $ids = [];
        foreach ($rows as $row) {
            $ids[] = $row['identifier'];
        }
        return $ids;
    }


    public function listIdName(string $language): array
    {
        $query = <<<QUERY
        SELECT article.identifier, article_translates.name 
        FROM article, article_translates
        WHERE article.active = 'true' 
            AND article.identifier = article_translates.article_id
            AND article_translates.language = $1
        QUERY;

        $rows = $this->database->queryParams($query, [$language]);
        $dtos = [];
        foreach ($rows as $row) {
            $dtos[] = new ArticleIdNameDTO(
                $row['identifier'],
                $row['name'],
            );
        }
        return $dtos;
    }

    /** @param array<string,string> $row */
    protected function createFromRow(array $row): ArticleViewDTO
    {
        $articleViewDTO = $this->factory->create(
            $row['identifier'],
            $row['name'],
            $row['short_description'],
            $row['description'],
            json_decode($row['category']),
            $row['created_at'],
            new AuthorDTO(
                $row['author_id'],
                $row['author_description']
            ),
            $this->imageDTOFactory->create(
                $row['img_id'],
                $row['img_path'],
                $row['img_description'],
                $row['img_author_description']
            ),
            $this->audioDTOFactory->create(
                $row['audio_path'],
                $row['audio_description'],
            )
        );

        return $articleViewDTO;
    }


    protected function getByIdQuery(): string
    {
        return <<<QUERY
        WITH categories AS
        (
            SELECT category_translates.category_id,
                category_translates.name
            FROM category_translates
            WHERE category_translates.language = $1
        ), img_authors AS
        (
            SELECT author_translates.author_id,
                author_translates.description
            FROM author_translates
            WHERE author_translates.language = $1
        )       
        SELECT article.identifier,
            article_translates.name,
            article_translates.short_description,
            article_translates.description,
            article_translates.created_at,
            article_translates.updated_at,
            array_to_json (
                array (
                    select
                        categories.name
                    from
                        categories, article_category
                    where
                        article.identifier = article_category.article_id AND
                        categories.category_id = article_category.category_id
                )
            ) as category,
            author_translates.author_id,
            author_translates.description as author_description,
            img.path as img_path,
            img_translates.img_id,
            img_translates.description as img_description,

            audio_translates.description as audio_description,
            audio_translates.path as audio_path,

            img_authors.description as img_author_description
        FROM
            article,
            article_translates,
            author_translates,
            img,
            img_translates,
            audio_translates,
            img_authors
        WHERE 
            article.identifier = $2
            AND article.identifier = article_translates.article_id
            AND article.active = 'true'
            AND article_translates.language = $1
            AND author_translates.author_id = article.author_id
            AND author_translates.language = $1
            AND article.img_id = img.identifier
            AND img_translates.img_id = article.img_id
            AND img_translates.language = $1
            AND audio_translates.audio_id = article.audio_id
            AND audio_translates.language = $1
            AND img_authors.author_id = img.author_id
        QUERY;
    }
}
