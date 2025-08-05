<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Views\Html\VO;

use Romchik38\Site2\Application\Search\Article\Commands\List\ListCommand;
use Romchik38\Site2\Application\Search\Article\VO\Query;

final class QueryMetaData
{
    public readonly string $nameField;
    public readonly int $maxLength;

    public function __construct()
    {
        $this->nameField = ListCommand::QUERY_FILED;
        $this->maxLength = Query::MAX_QUERY_LENGTH;
    }
}
