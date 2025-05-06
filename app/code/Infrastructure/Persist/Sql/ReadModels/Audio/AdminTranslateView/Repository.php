<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Audio\AdminTranslateView;

use InvalidArgumentException;
use Romchik38\Server\Models\Errors\QueryException;
use Romchik38\Server\Persist\Sql\DatabaseSqlInterface;
use Romchik38\Site2\Application\Audio\AdminTranslateView\NoSuchTranslateException;
use Romchik38\Site2\Application\Audio\AdminTranslateView\RepositoryException;
use Romchik38\Site2\Application\Audio\AdminTranslateView\RepositoryInterface;
use Romchik38\Site2\Application\Audio\AdminTranslateView\SearchCriteria;
use Romchik38\Site2\Application\Audio\AdminTranslateView\View\TranslateDto;
use Romchik38\Site2\Domain\Audio\VO\Description;
use Romchik38\Site2\Domain\Audio\VO\Id as AudioId;
use Romchik38\Site2\Domain\Audio\VO\Path;
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
                'Audio translate with id %s and language %s not exist',
                (string) $audioId,
                $language()
            ));
        }
        if ($count > 1) {
            throw new RepositoryException(sprintf(
                'Audio translate with id %s and language %s has duplicates',
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
        $rawDescription = $row['description'] ?? null;
        if ($rawDescription === null) {
            throw new RepositoryException('Audio translate description is invalid');
        }

        $rawPath = $row['path'] ?? null;
        if ($rawPath === null) {
            throw new RepositoryException('Audio translate path is invalid');
        }

        return new TranslateDto(
            $audioId,
            $language,
            new Description($rawDescription),
            new Path($rawPath)
        );
    }

    private function findQuery(): string
    {
        return <<<'QUERY'
            SELECT audio_translates.description,
                audio_translates.path
            FROM audio_translates
            WHERE audio_translates.audio_id = $1 
                AND audio_translates.language = $2
        QUERY;
    }
}
