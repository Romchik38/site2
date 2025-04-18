<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Audio\AdminTranslateCreate;

use InvalidArgumentException;
use Romchik38\Server\Models\Errors\QueryException;
use Romchik38\Server\Models\Sql\DatabaseSqlInterface;
use Romchik38\Site2\Application\Audio\AdminTranslateCreate\NoSuchTranslateException;
use Romchik38\Site2\Application\Audio\AdminTranslateCreate\RepositoryException;
use Romchik38\Site2\Application\Audio\AdminTranslateCreate\RepositoryInterface;
use Romchik38\Site2\Application\Audio\AdminTranslateCreate\SearchCriteria;
use Romchik38\Site2\Application\Audio\AdminTranslateCreate\View\TranslateDto;
use Romchik38\Site2\Domain\Audio\VO\Id as AudioId;
use Romchik38\Site2\Domain\Audio\VO\Name;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

use function count;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    /**
     * @throws NoSuchTranslateException
     * @throws RepositoryException
     */
    public function find(SearchCriteria $searchCriteria): TranslateDto
    {
        $audioId  = $searchCriteria->audioId;
        $language = $searchCriteria->language;
        $query    = $this->findQuery();
        $params   = [$audioId(), $language()];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $count = count($rows);
        if ($count === 0) {
            throw new NoSuchTranslateException(sprintf(
                'Translate with audio id %s and language %s can not be created',
                (string) $audioId,
                $language()
            ));
        }
        if ($count > 1) {
            throw new RepositoryException(sprintf(
                'Translate with audio id %s and language %s has duplicates',
                (string) $audioId,
                $language()
            ));
        }

        $rawTranslate = $rows[0];

        try {
            $dto = $this->createFromRow($audioId, $language, $rawTranslate);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        return $dto;
    }

    /**
     * @throws InvalidArgumentException
     * @param array<string,string> $row
     * */
    private function createFromRow(
        AudioId $audioId,
        LanguageId $language,
        array $row
    ): TranslateDto {
        $rawName = $row['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Audio name is invalid');
        }

        try {
            $name = new Name($rawName);
        } catch (InvalidArgumentException $e) {
            throw new RepositoryException($e->getMessage());
        }

        return new TranslateDto(
            $audioId,
            $language,
            $name
        );
    }

    private function findQuery(): string
    {
        return <<<'QUERY'
            SELECT audio.name,
                language.identifier as language
            FROM audio, language
            WHERE audio.identifier = $1 
                AND language.identifier = $2
        QUERY;
    }
}
