<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\AdminUser\VO;

final class Active
{
    public const FIELD = 'active';
    
    /** @throws InvalidArgumentExceptions */
    public function __construct(
        public readonly bool $active
    ){
    }
}