<?php

declare(strict_types=1);

interface MetadataInterface
{
    /** 
     * @throws MetadataException 
     * @return array<string,mixed>
     * */
    public function getAllData(): array;
}