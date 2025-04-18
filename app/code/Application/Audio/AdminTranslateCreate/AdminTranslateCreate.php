<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AdminTranslateCreate;

use Romchik38\Site2\Application\Audio\AdminTranslateCreate\View\AudioRequirementsDto;
use Romchik38\Site2\Application\Audio\AdminTranslateCreate\View\TranslateDto;
use Romchik38\Site2\Domain\Audio\VO\Id as AudioId;
use Romchik38\Site2\Domain\Audio\VO\Size;
use Romchik38\Site2\Domain\Audio\VO\Type;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class AdminTranslateCreate
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws CouldNotFindException
     * @throws InvalidArgumentException
     * */
    public function find(Find $command): TranslateDto
    {
        $searchCriteria = new SearchCriteria(
            AudioId::fromString($command->id),
            new LanguageId($command->language)
        );

        try {
            $translate = $this->repository->find($searchCriteria);
        } catch (RepositoryException $e) {
            throw new CouldNotFindException($e->getMessage());
        } catch (NoSuchTranslateException $e) {
            throw new CouldNotFindException($e->getMessage());
        }

        return $translate;
    }

    public function audioRequirements(): AudioRequirementsDto
    {
        return new AudioRequirementsDto(
            Size::MAX_VALUE,
            Type::ALLOWED_TYPES
        );
    }
}
