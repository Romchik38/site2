<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ImgConverter\View;

use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Domain\Img\VO\Id;

interface ImgViewRepositoryInterface
{
    /** 
     * @throws NoSuchEntityException 
     * @throws RuntimeException - On duplicates
     * */
    public function getById(Id $id): ImgView;
}
