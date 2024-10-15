<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\Link;

use Romchik38\Server\Api\Models\ModelInterface;
use Romchik38\Server\Models\Errors\InvalidArgumentException;

interface LinkInterface extends ModelInterface
{
    public function getId(): int;
    public function getName(): string;
    public function getDescription(): string;
    public function getUrl(): array;

    /**
     * @throws InvalidArgumentException when id is 0
     */
    public function setId(int $id): int;

    /**
     * @throws InvalidArgumentException when string length is 0
     */
    public function setName(string $name): string;

    /**
     * @throws InvalidArgumentException when string length is 0
     */
    public function setDescription(string $description): string;

    /**
     * @throws InvalidArgumentException when array length is 0
     */
    public function setUrl(array $url): array;
}
