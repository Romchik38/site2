<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\SearchCriteria;

interface OrderByInterface
{
    final const ASC_DIRECTION = 'ASC';
    final const DESC_DIRECTION = 'DESC';
    final const NULLS_FIRST_OPTION = 'NULLS FIRST';
    final const NULLS_LAST_OPTION = 'NULLS LAST';

    public function getField(): string;
    public function getDirection(): string;
    public function getNulls(): string;
}
