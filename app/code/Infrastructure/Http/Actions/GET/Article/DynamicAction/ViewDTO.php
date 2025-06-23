<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Article\DynamicAction;

use DateTime;
use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Article\View\View\ArticleViewDTO;

final class ViewDTO extends DefaultViewDTO
{
    public function __construct(
        string $name,
        string $description,
        public readonly ArticleViewDTO $article,
        private readonly TranslateInterface $translate,
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
