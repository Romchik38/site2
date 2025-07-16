<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\PageService;

use InvalidArgumentException;
use Romchik38\Site2\Application\Language\List\Exceptions\RepositoryException as LanguageRepositoryException;
use Romchik38\Site2\Application\Language\List\ListService as LanguageListService;
use Romchik38\Site2\Application\Page\PageService\Commands\Create;
use Romchik38\Site2\Application\Page\PageService\Commands\Delete;
use Romchik38\Site2\Application\Page\PageService\Commands\Update;
use Romchik38\Site2\Application\Page\PageService\Exceptions\CouldNotCreateException;
use Romchik38\Site2\Application\Page\PageService\Exceptions\CouldNotDeleteException;
use Romchik38\Site2\Application\Page\PageService\Exceptions\CouldNotUpdateException;
use Romchik38\Site2\Application\Page\PageService\Exceptions\NoSuchPageException;
use Romchik38\Site2\Application\Page\PageService\Exceptions\RepositoryException;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use Romchik38\Site2\Domain\Page\CouldNotChangeActivityException;
use Romchik38\Site2\Domain\Page\Entities\Translate;
use Romchik38\Site2\Domain\Page\Page;
use Romchik38\Site2\Domain\Page\VO\Description;
use Romchik38\Site2\Domain\Page\VO\Id as PageId;
use Romchik38\Site2\Domain\Page\VO\Name;
use Romchik38\Site2\Domain\Page\VO\ShortDescription;
use Romchik38\Site2\Domain\Page\VO\Url;

use function sprintf;

final class PageService
{
    public function __construct(
        private readonly RepositoryInterface $repository,
        private readonly LanguageListService $languagesService
    ) {
    }

    /**
     * @throws CouldNotCreateException
     * @throws InvalidArgumentException
     */
    public function create(Create $command): PageId
    {
        $url = new Url($command->url);

        try {
            $languages = [];
            foreach ($this->languagesService->getAll() as $language) {
                $languages[] = $language->identifier;
            }
        } catch (LanguageRepositoryException $e) {
            throw new CouldNotCreateException($e->getMessage());
        }

        $model = Page::create($url, $languages);

        try {
            return $this->repository->add($model);
        } catch (RepositoryException $e) {
            throw new CouldNotCreateException($e->getMessage());
        }
    }

    /**
     * @throws CouldNotChangeActivityException
     * @throws CouldNotDeleteException
     * @throws InvalidArgumentException
     * @throws NoSuchPageException
     */
    public function delete(Delete $command): void
    {
        $id = PageId::fromString($command->id);

        try {
            $this->repository->transactionStart();
            try {
                $model = $this->repository->getById($id);
            } catch (NoSuchPageException $e) {
                $this->repository->transactionCancel();
                throw new NoSuchPageException($e->getMessage());
            }

            try {
                $model->deactivate();
            } catch (CouldNotChangeActivityException $e) {
                $this->repository->transactionCancel();
                throw new CouldNotChangeActivityException($e->getMessage());
            }

            $this->repository->delete($model);
            $this->repository->transactionEnd();
        } catch (RepositoryException $e) {
            try {
                $this->repository->transactionCancel();
                throw new CouldNotDeleteException(sprintf(
                    'Could not delete Page, transaction canceled: %s',
                    $e->getMessage()
                ));
            } catch (RepositoryException $eCancel) {
                throw new CouldNotDeleteException(sprintf(
                    'Could not delete Page: %s; Could not cancel transaction: %s',
                    $e->getMessage(),
                    $eCancel->getMessage()
                ));
            }
        }
    }

    /**
     * @throws CouldNotChangeActivityException
     * @throws CouldNotUpdateException
     * @throws InvalidArgumentException
     * @throws NoSuchPageException
     */
    public function update(Update $command): void
    {
        $id         = PageId::fromString($command->id);
        $url        = new Url($command->url);
        $translates = [];
        foreach ($command->translates as $translate) {
            $language         = new LanguageId($translate->language);
            $name             = new Name($translate->name);
            $shortDescription = new ShortDescription($translate->shortDescription);
            $description      = new Description($translate->description);
            $translates[]     = new Translate($language, $name, $shortDescription, $description);
        }

        try {
            $this->repository->transactionStart();
            try {
                $model = $this->repository->getById($id);
            } catch (NoSuchPageException $e) {
                $this->repository->transactionCancel();
                throw new NoSuchPageException($e->getMessage());
            }
            $model->url = $url;
            //translates
            foreach ($translates as $translate) {
                $model->addTranslate($translate);
            }
            // Activity
            if ($command->changeActivity === Update::CHANGE_ACTIVITY_YES_FIELD) {
                try {
                    if ($model->active) {
                        $model->deactivate();
                    } else {
                        $model->activate();
                    }
                } catch (CouldNotChangeActivityException $e) {
                    $this->repository->transactionCancel();
                    throw new CouldNotChangeActivityException($e->getMessage());
                }
            }

            $this->repository->save($model);
            $this->repository->transactionEnd();
        } catch (RepositoryException $e) {
            try {
                $this->repository->transactionCancel();
                throw new CouldNotUpdateException(sprintf(
                    'Could not update Page, transaction canceled: %s',
                    $e->getMessage()
                ));
            } catch (RepositoryException $eCancel) {
                throw new CouldNotUpdateException(sprintf(
                    'Could not update Page: %s; Could not cancel transaction: %s',
                    $e->getMessage(),
                    $eCancel->getMessage()
                ));
            }
        }
    }
}
