<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\Translate;

use Romchik38\Server\Models\Errors\QueryException;
use Romchik38\Server\Models\Sql\DatabaseInterface;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use Romchik38\Site2\Domain\Translate\RepositoryInterface;
use Romchik38\Site2\Domain\Translate\RepositoryException;
use Romchik38\Site2\Domain\Translate\NoSuchTranslateException;
use Romchik38\Site2\Domain\Translate\CouldNotSaveException;
use Romchik38\Site2\Domain\Translate\CouldDeleteException;
use Romchik38\Site2\Domain\Translate\Entities\Phrase;
use Romchik38\Site2\Domain\Translate\Translate;
use Romchik38\Site2\Domain\Translate\VO\Identifier;
use Romchik38\Site2\Domain\Translate\VO\Phrase as VOPhrase;

final class Repository implements RepositoryInterface
{
    public  function __construct(
        private  readonly DatabaseInterface $database
    ) {   
    }

    /**
     * @throws NoSuchTranslateException
     * @throws RepositoryException
     * */
    public function getById(Identifier $id): Translate
    {
        $query = $this->getByIdQuery();
        $params = [$id()];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch(QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        if (count($rows) === 0) {
            throw new NoSuchTranslateException(sprintf(
                'Translate with id %s not exist',
                $id()
            ));
        }

        $phrases = [];
        foreach ($rows as $row) {
            $result = $this->createPhrase($row);
            if ($result === null) {
                continue;
            } else {
                $phrases[] = $result;
            }
        }

        return new Translate($id, $phrases);
    }

    /** @throws CouldDeleteException */
    public function deleteById(Identifier $id): void
    {

    }

    /** @throws CouldNotSaveException */
    public function save(Translate $model): Translate
    {

    }

    /** @throws CouldNotSaveException */
    public function add(Translate $model): Translate
    {

    }

    /** @return PhraseDto */
    private function createPhrase(array $row): ?Phrase
    {
        $rawLanguage = $row['language'] ?? null;
        if ($rawLanguage === null) {
            throw new RepositoryException('Translate language is ivalid');
        }
        $rawPhrase = $row['phrase'] ?? null;
        if ($rawPhrase === null) {
            throw new RepositoryException('Translate phrase is ivalid');
        }
        if (strlen($rawLanguage) === 0 && strlen($rawPhrase) === 0) {
            return null;
        } else {
            return new Phrase(
                new LanguageId($rawLanguage),
                new VOPhrase($rawPhrase)
            );
        }
    }

    private function getByIdQuery(): string
    {
        return <<<'QUERY'
        SELECT translate_keys.identifier,
            translate_entities.language,
            translate_entities.phrase
        FROM translate_keys
            LEFT JOIN translate_entities 
                ON translate_keys.identifier = translate_entities.key
        WHERE translate_keys.identifier = $1
        ;
        QUERY;
    }
}