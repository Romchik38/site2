<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ArticleService;

use Romchik38\Site2\Application\Article\ArticleService\Commands\Update;
use Romchik38\Site2\Application\Article\ArticleService\Exceptions\{
    CouldNotCreateException,
    CouldNotDeleteException,
    CouldNotUpdateException,
    NoSuchArticleException,
    RepositoryException
};
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Article\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\Article\Entities\Translate;
use DateTime;
use Romchik38\Site2\Domain\Article\VO\Description;
use Romchik38\Site2\Domain\Article\VO\Name;
use Romchik38\Site2\Domain\Article\VO\ShortDescription;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class ArticleService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @todo test all paths
     * 
     * @throws CouldNotChangeActivityException
     * @throws CouldNotUpdateException
     * @throws InvalidArgumentException
     * @throws NoSuchArticleException
     */
    public function update(Update $command): void
    {
        $id = new ArticleId($command->id);

        try {
            $model = $this->repository->getById($id);
        } catch (RepositoryException $e) {
            throw new CouldNotUpdateException($e->getMessage());
        }

        
        // translates
        foreach ($command->translates as $translate) {
            $existingTranslate = $model->getTranslate($translate->language);
            if ($existingTranslate === null) {
                $createdAt = new DateTime();
                $updatedAt = new DateTime();
            } else {

            }
            $model->addTranslate(new Translate(
                new LanguageId($translate->language),
                new Name($translate->name),
                new ShortDescription($translate->shortDescription),
                new Description($translate->description),

            ));
        }

        $model;
    }
}
