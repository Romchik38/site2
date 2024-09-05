<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\TranslateEntity;

use Romchik38\Server\Api\Models\RepositoryInterface;

interface TranslateEntityModelRepositoryInterface extends RepositoryInterface
{

    /**
     * Get a list of the translate entities by provided language
     * 
     * @param string $lang language
     * @return TranslateEntityModelInterface[] 
     */
    public function getListByLang(string $lang): array;
}
