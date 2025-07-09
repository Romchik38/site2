<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Article\DynamicAction;

use DateTime;
use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Article\SimilarArticles\View\ArticleDto as SimilarArticleDto;
use Romchik38\Site2\Application\Article\View\View\ArticleViewDTO;

use function date_format;
use function sprintf;

final class ViewDTO extends DefaultViewDTO
{
    /** @param array<int,SimilarArticleDto> $similarArticles */
    public function __construct(
        string $name,
        string $description,
        public readonly ArticleViewDTO $article,
        private readonly TranslateInterface $translate,
        public readonly string $idField,
        public readonly string $csrfTokenField,
        public string $csrfToken,
        public readonly array $similarArticles
    ) {
        parent::__construct($name, $description);
    }

    public function formatArticleDate(DateTime $date): string
    {
        return sprintf(
            '%s %s %s',
            date_format($date, 'j'),
            $this->translate->t('article.view.month.' . date_format($date, 'F')),
            date_format($date, 'y G:i')
        );
    }
}
