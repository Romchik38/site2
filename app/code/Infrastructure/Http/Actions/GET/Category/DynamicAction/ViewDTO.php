<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Category\DynamicAction;

use DateTime;
use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\Banner\List\View\BannerDto;
use Romchik38\Site2\Application\Category\View\View\CategoryDto;
use Romchik38\Site2\Infrastructure\Http\Views\Html\CreatePaginationInterface;
use Romchik38\Site2\Application\Article\MostVisited\Views\ArticleDTO as ArticleMostVisitedDto;

use function count;
use function date_format;
use function explode;
use function round;
use function sprintf;

final class ViewDTO extends DefaultViewDTO
{
    private const int READING_SPEED = 200;

    /** 
     * @param array<int,ArticleMostVisitedDto> $mostVisited
     */
    public function __construct(
        string $name,
        string $description,
        public readonly CategoryDto $category,
        private readonly CreatePaginationInterface $paginationView,
        public readonly PaginationForm $paginationForm,
        public readonly string $articlePageUrl,
        public readonly ?BannerDto $banner,
        private readonly TranslateInterface $translate,
        public readonly array $mostVisited
    ) {
        parent::__construct($name, $description);
    }

    public function calculateReadLength(string $description): string
    {
        $words         = count(explode(' ', $description));
        $minutesToRead = (int) round($words / $this::READING_SPEED);
        if ($minutesToRead < 10) {
            return $this->translate->t('read-length-formatter.a-few-minutes');
        }

        if ($minutesToRead < 60) {
            return sprintf(
                '%s %s',
                $minutesToRead,
                $this->translate->t('read-length-formatter.min')
            );
        }

        $hours = (int) ($minutesToRead / 60);

        if ($hours < 24) {
            return sprintf(
                '%s %s',
                $hours,
                $this->translate->t('read-length-formatter.hour')
            );
        }

        $days = (int) ($hours / 24);

        return sprintf(
            '%s %s',
            $days,
            $this->translate->t('read-length-formatter.day')
        );
    }

    public function formatArticleDate(DateTime $date): string
    {
        return date_format($date, 'j-n-y');
    }

    public function showPagination(): string
    {
        return $this->paginationView->create();
    }
}
