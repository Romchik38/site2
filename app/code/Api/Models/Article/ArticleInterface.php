<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\Article;

interface ArticleInterface {
    final const ENTITY_NAME = 'article';
    
    final const ID_FIELD = 'identifier';
    final const ACTIVE_FIELD = 'active';

    /** Persistant data */
    public function getId(): string;
    public function getActive(): bool;

    /** @throws InvalidArgumentException when string is empty */
    public function setId(string $id): ArticleInterface;

    public function activate(): ArticleInterface;
    public function deactivate(): ArticleInterface;
}