<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\List;

use InvalidArgumentException;
use Romchik38\Site2\Application\Category\List\Exceptions\CouldNotListException;
use Romchik38\Site2\Application\Category\List\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Category\List\View\CategoryDto;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class ListService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws CouldNotListException
     * @throws InvalidArgumentException
     * @return array<int,CategoryDto>
     */
    public function list(string $language): array
    {
        $languageId = new LanguageId($language);

        try {
            return $this->repository->list($languageId);
        } catch (RepositoryException $e) {
            throw new CouldNotListException($e->getMessage());
        }
    }
}
