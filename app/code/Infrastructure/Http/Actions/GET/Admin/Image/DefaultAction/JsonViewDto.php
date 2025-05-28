<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image\DefaultAction;

use Romchik38\Server\Http\Views\Dto\Api\ApiDTO;
use Romchik38\Site2\Application\Image\AdminImageListService\View\ImageDto;

class JsonViewDto extends ApiDTO
{
    public const FILTER_RESULT_FIELD = 'filter_result';
    public const IMAGE_LIST_FIELD    = 'image_list';
    public const TOTAL_COUNT_FIELD   = 'total_count';

    /** @param array<int,ImageDto> $imagesList */
    public function __construct(
        string $name,
        string $description,
        string $status,
        array $imagesList,
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
        foreach ($imagesList as $image) {
             $arr[] = $image->jsonSerialize();
        }
        $result = [
            self::FILTER_RESULT_FIELD => [
                $pageField             => $page,
                $limitField            => $limit,
                $orderByField          => $orderBy,
                $orderByDirectionField => $orderByDirection,
            ],
            self::IMAGE_LIST_FIELD    => $arr,
            self::TOTAL_COUNT_FIELD   => $totalCount,
        ];
        parent::__construct($name, $description, $status, $result);
    }
}
