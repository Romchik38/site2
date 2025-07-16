<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\View;

use InvalidArgumentException;
use Romchik38\Site2\Application\Page\View\Commands\Find\Find;
use Romchik38\Site2\Application\Page\View\Commands\Find\SearchCriteria;
use Romchik38\Site2\Application\Page\View\View\ListDto;
use Romchik38\Site2\Application\Page\View\View\PageDto;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use Romchik38\Site2\Domain\Page\VO\Url;

final class ViewService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws CouldNotFindException
     * @throws InvalidArgumentException
     * @throws NoSuchPageException
     * */
    public function find(Find $command): PageDto
    {
        $url        = new Url($command->url);
        $languageId = new LanguageId($command->language);

        $searchCriteria = new SearchCriteria($url, $languageId);

        try {
            return $this->repository->find($searchCriteria);
        } catch (RepositoryException $e) {
            throw new CouldNotFindException($e->getMessage());
        }
    }

    /**
     * @throws InvalidArgumentException
     * @throws CouldNotListNamesException
     * @return array<int,ListDto>
     * */
    public function list(string $language): array
    {
        $languageId = new LanguageId($language);

        try {
            return $this->repository->list($languageId);
        } catch (RepositoryException $e) {
            throw new CouldNotListNamesException($e->getMessage());
        }
    }
}
