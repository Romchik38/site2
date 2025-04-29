<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Translate\View;

use InvalidArgumentException;
use Romchik38\Server\Models\Errors\QueryException;
use Romchik38\Server\Models\Sql\DatabaseSqlInterface;
use Romchik38\Site2\Application\Translate\View\Exceptions\NoSuchTranslateException;
use Romchik38\Site2\Application\Translate\View\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Translate\View\RepositoryInterface;
use Romchik38\Site2\Application\Translate\View\View\PhraseDto;
use Romchik38\Site2\Application\Translate\View\View\TranslateDto;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use Romchik38\Site2\Domain\Translate\VO\Identifier;
use Romchik38\Site2\Domain\Translate\VO\Phrase;

use function count;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function getById(Identifier $id): TranslateDto
    {
        $idAsString = $id();
        $params     = [$idAsString];

        $query = $this->defaultQuery();

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $rowCount = count($rows);
        if ($rowCount === 0) {
            throw new NoSuchTranslateException(sprintf(
                'Translate with id %s not exist',
                $idAsString
            ));
        }
        if ($rowCount > 1) {
            throw new RepositoryException(sprintf(
                'Translate with id %s has duplicates',
                $idAsString
            ));
        }

        $phrases = $this->createPhrases($id);

        return new TranslateDto($id, $phrases);
    }

    /**
     * @throws RepositoryException
     * @return array<int,PhraseDto>
     * */
    private function createPhrases(Identifier $id): array
    {
        $query  = $this->phrasesQuery();
        $params = [$id()];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $phrases = [];

        foreach ($rows as $row) {
            $rawLanguage = $row['language'] ?? null;
            if ($rawLanguage === null) {
                throw new RepositoryException('Translate language is invalid');
            }
            $rawPhrase = $row['phrase'] ?? null;
            if ($rawPhrase === null) {
                throw new RepositoryException('Translate phrase is invalid');
            }
            try {
                $language = new LanguageId($rawLanguage);
                $phrase   = new Phrase($rawPhrase);
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }
            $phrases[] = new PhraseDto($language, $phrase);
        }

        return $phrases;
    }

    private function defaultQuery(): string
    {
        return <<<'QUERY'
        SELECT translate_keys.identifier
        FROM translate_keys
        WHERE translate_keys.identifier = $1
        QUERY;
    }

    private function phrasesQuery(): string
    {
        return <<<'QUERY'
        SELECT translate_entities.language,
            translate_entities.phrase
        FROM translate_entities
        WHERE translate_entities.key = $1
        QUERY;
    }
}
