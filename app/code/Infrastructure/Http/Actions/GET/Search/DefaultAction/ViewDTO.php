<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Search\DefaultAction;

use DateTime;
use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Search\Article\Commands\List\ListCommand;
use Romchik38\Site2\Application\Search\Article\View\ArticleDto;

use function date_format;
use function sprintf;

final class ViewDTO extends DefaultViewDTO
{
    /** @param array<int,ArticleDTO> $articleList */
    public function __construct(
        string $name,
        string $description,
        public readonly array $articleList,
        public readonly ?string $query,
        private readonly TranslateInterface $translate,
        public readonly string $paginationHtml,
        public readonly QueryMetaData $queryMetaData
    ) {
        parent::__construct($name, $description);
    }

    public function getQueryField(): string
    {
        return ListCommand::QUERY_FILED;
    }

    public function formatArticleDate(DateTime $date): string
    {
        return sprintf(
            '%s %s %s',
            date_format($date, 'j'),
            $this->translate->t('article.view.month.' . date_format($date, 'F')),
            date_format($date, 'Y')
        );
    }
}
