<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\Sql\SearchCriteria;

interface OrderByInterface
{
    const ASC_DIRECTION = 'ASC';
    const DESC_DIRECTION = 'DESC';
    const NULLS_FIRST_OPTION = 'NULLS FIRST';
    const NULLS_LAST_OPTION = 'NULLS LAST';

    public function getField(): string;
    public function getDirection(): string;
    public function getNulls(): string;
}
