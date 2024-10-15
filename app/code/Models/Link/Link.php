<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\Link;

use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Server\Models\Model;
use Romchik38\Site2\Api\Models\Link\LinkInterface;

final class Link extends Model implements LinkInterface
{

    public function getId(): int
    {
        return $this->data[LinkInterface::LINK_ID_FIELD];
    }
    public function getName(): string
    {
        return $this->data[LinkInterface::NAME_FIELD];
    }

    public function getDescription(): string
    {
        return $this->data[LinkInterface::DESCRIPTION_FIELD];
    }
    public function getUrl(): array
    {
        return $this->data[LinkInterface::URL_FIELD];
    }

    /**
     * @throws InvalidArgumentException when id is 0
     */
    public function setId(int $id): LinkInterface
    {
        if ($id === 0) {
            throw new InvalidArgumentException('Id must not be equal 0');
        }
        $this->data[LinkInterface::LINK_ID_FIELD] = $id;
        return $this;
    }

    /**
     * @throws InvalidArgumentException when string length is 0
     */
    public function setName(string $name): LinkInterface
    {
        if (strlen($name) === 0) {
            throw new InvalidArgumentException('name length is 0');
        }
        $this->data[LinkInterface::NAME_FIELD] = $name;
        return $this;
    }

    /**
     * @throws InvalidArgumentException when string length is 0
     */
    public function setDescription(string $description): LinkInterface
    {
        if (strlen($description) === 0) {
            throw new InvalidArgumentException('description length is 0');
        }
        $this->data[LinkInterface::DESCRIPTION_FIELD] = $description;
        return $this;
    }

    /**
     * @throws InvalidArgumentException when array length is 0
     */
    public function setUrl(array $url): LinkInterface
    {
        if (count($url) === 0) {
            throw new InvalidArgumentException('url length is 0');
        }
        $this->data[LinkInterface::URL_FIELD] = $url;
        return $this;
    }
}
