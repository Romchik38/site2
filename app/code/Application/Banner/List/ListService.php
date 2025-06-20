<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Banner\List;

use Romchik38\Site2\Application\Banner\List\Exceptions\NoBannerToDisplayException;
use Romchik38\Site2\Application\Banner\List\Exceptions\PriorityException;
use Romchik38\Site2\Application\Banner\List\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Banner\List\View\BannerDto;
use RuntimeException;
use SplFixedArray;

use function count;
use function rand;

final class ListService
{
    public const ALLOVED_BANNERS_COUNT = 100;

    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * List active banners
     *
     * @throws RepositoryException
     * @return array<int,BannerDto>
     * */
    public function list(): array
    {
        return $this->repository->list();
    }

    /**
     * @throws NoBannerToDisplayException
     * @throws PriorityException
     * */
    public function priority(): BannerDto
    {
        try {
            $list = $this->list();
        } catch (RepositoryException $e) {
            throw new PriorityException($e->getMessage());
        }

        if (count($list) === 0) {
            throw new NoBannerToDisplayException('No banner to display');
        }

        try {
            return $this->makeDesicion($list);
        } catch (RuntimeException $e) {
            throw new PriorityException($e->getMessage());
        }
    }

    /**
     * @param array<int,BannerDto> $banners
     * @throws RuntimeException
     * */
    private function makeDesicion(array $banners): BannerDto
    {
        /** @todo test */
        $bannersCount = count($banners);
        if ($bannersCount > $this::ALLOVED_BANNERS_COUNT) {
            throw new RuntimeException('Too many banners');
        }

        if ($bannersCount === 1) {
            return $banners[0];
        }

        $arrLength = 0;
        foreach ($banners as $banner) {
            $arrLength += ($banner->priority)();
        }

        $arr      = new SplFixedArray($arrLength);
        $arrIndex = 0;

        foreach ($banners as $banner) {
            for ($i = 0; $i < ($banner->priority)(); $i++) {
                $arr[$arrIndex] = ($banner->id)();
                $arrIndex++;
            }
        }

        $number   = rand(0, $arrLength - 1);
        $bannerId = $arr[$number];

        foreach ($banners as $banner) {
            if ($bannerId === ($banner->id)()) {
                return $banner;
            }
        }

        throw new RuntimeException('Banner did not choosen, error with logic');
    }
}
