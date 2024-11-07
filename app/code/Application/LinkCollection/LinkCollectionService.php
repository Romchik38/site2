<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\Link;

use Romchik38\Server\Api\Models\DTO\Http\Link\LinkDTOCollectionInterface;
use Romchik38\Server\Api\Models\DTO\Http\Link\LinkDTOFactoryInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Site2\Domain\Link\LinkRepositoryInterface;

final class LinkCollectionService implements LinkDTOCollectionInterface
{
    public function __construct(
        protected LinkDTOFactoryInterface $linkDTOFactory,
        protected LinkRepositoryInterface $linkRepository,
        protected DynamicRootInterface $dynamicRoot
    ) {}

    public function getLinksByPaths(array $paths = []): array
    {
        $language = $this->dynamicRoot->getCurrentRoot()->getName();
        $result = [];

        // 1. Get Models from a Repository
        $models = $this->linkRepository->getLinksByLanguageAndPaths($language, $paths);
        if (count($models) === 0) {
            return $result;
        }

        // 2. Create LinkDTOs
        /** @var LinkInterface $model */
        foreach ($models as $model) {
            $modelPath = $model->getPath();
            $modelPath[0] = $language;
            $url = sprintf('/%s', implode('/', $modelPath));
            $dto = $this->linkDTOFactory->create(
                $model->getName(),
                $model->getDescription(),
                $url
            );
            $result[] = $dto;
        }

        // 3. Return an array with DTOs
        return $result;
    }
}
