<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\Virtual\Article;

use DateTime;
use Romchik38\Server\Api\Models\ModelInterface;

/**
 * Article entity
 * 
 * @api
 */
interface ArticleInterface extends ModelInterface {
    final const ID_FIELD = 'identifier';
    final const ACTIVE_FIELD = 'active';
    final const LANGUAGE_FIELD = 'language';
    final const NAME_FIELD = 'name';
    final const DESCRIPTION_FIELD = 'description';
    final const CREATED_at_FIELD = 'created_at';
    final const UPDATED_AT_FIELD = 'updated_at';
    final const CATEGORY_ID_FIELD = 'category_id';

    public function getId(): string;
    public function getActive(): bool;
    public function getLanguage(): string;
    public function getName(): string;
    public function getDescription(): string;
    public function getCreatedAt(): DateTime;
    public function getUpdated_at(): DateTime;

    /** @return string[] */
    public function getCategory_id(): array;

}