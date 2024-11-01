<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\ArticleTranslates;

interface ArticleTranslatesInterface {
    final const ENTITY_NAME = 'article_translates';

    final const ARTICLE_ID_FIELD = 'article_id';
    final const LANGUAGE_FIELD = 'language';
    final const NAME_FIELD = 'name';
    final const SHORT_DESCRIPTION_FIELD = 'short_description';
    final const DESCRIPTION_FIELD = 'description';
    final const CREATED_AT_FIELD = 'created_at';
    final const UPDATED_AT_FIELD = 'updated_at';

    public function getArticleId(): string;
    public function getLanguage(): string;
    public function getName(): string;
    public function getShortDescription(): string;
    public function getDescription(): string;
    public function getCreatedAt(): \DateTime;
    public function getUpdatedAt(): \DateTime;

    /** @throws InvalidArgumentException when string is empty */
    public function setArticleId(string $id): ArticleTranslatesInterface;

    /** @throws InvalidArgumentException when string is empty */
    public function setLanguage(string $language): ArticleTranslatesInterface;

    /** @throws InvalidArgumentException when string is empty */
    public function setName(string $name): ArticleTranslatesInterface;

    /** @throws InvalidArgumentException when string is empty */
    public function setShortDescription(string $description): ArticleTranslatesInterface;

    /** @throws InvalidArgumentException when string is empty */
    public function setDescription(string $description): ArticleTranslatesInterface;

    public function setCreatedAt(\DateTime $date): ArticleTranslatesInterface;

    public function setUpdatedAt(\Datetime $date): ArticleTranslatesInterface;

    /** Additional */

    /**
     * @throws InvalidArgumentException $speed must be greater than 0
     * @param int $speed words/minute 
     * @return int Minutes to read
     */
    public function getReadLength(int $speed = 200): int;
}