<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author\DynamicAction;

use Romchik38\Server\Http\Views\Dto\Api\ApiDTO;
use Romchik38\Site2\Application\Author\AdminList\View\AuthorDto;

class JsonViewDto extends ApiDTO
{
    public const FILTER_RESULT_FIELD = 'filter_result';
    public const AUTHOR_LIST_FIELD   = 'author_list';
    public const TOTAL_COUNT_FIELD   = 'total_count';

    /** @param array<int,AuthorDto> $authorsList */
    public function __construct(
        string $name,
        string $description,
        string $status,
        array $authorsList,
        int $totalCount,
        int $limit,
        string $limitField,
        int $page,
        string $pageField,
        string $orderBy,
        string $orderByField,
        string $orderByDirection,
        string $orderByDirectionField
    ) {
        $arr = [];
        foreach ($authorsList as $author) {
             $arr[] = $author->jsonSerialize();
        }
        $result = [
            self::FILTER_RESULT_FIELD => [
                $pageField             => $page,
                $limitField            => $limit,
                $orderByField          => $orderBy,
                $orderByDirectionField => $orderByDirection,
            ],
            self::AUTHOR_LIST_FIELD   => $arr,
            self::TOTAL_COUNT_FIELD   => $totalCount,
        ];
        parent::__construct($name, $description, $status, $result);
    }
}
