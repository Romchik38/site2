<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Audio\AdminView;

use InvalidArgumentException;
use Romchik38\Server\Models\Errors\QueryException;
use Romchik38\Server\Models\Sql\DatabaseSqlInterface;
use Romchik38\Site2\Application\Audio\AdminView\NoSuchAudioException;
use Romchik38\Site2\Application\Audio\AdminView\RepositoryException;
use Romchik38\Site2\Application\Audio\AdminView\RepositoryInterface;
use Romchik38\Site2\Application\Audio\AdminView\View\AudioDto;
use Romchik38\Site2\Application\Audio\AdminView\View\Translate;
use Romchik38\Site2\Domain\Article\VO\ArticleId;
use Romchik38\Site2\Domain\Audio\VO\Description;
use Romchik38\Site2\Domain\Audio\VO\Id;
use Romchik38\Site2\Domain\Audio\VO\Name;
use Romchik38\Site2\Domain\Audio\VO\Path;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

use function count;
use function json_decode;
use function sprintf;

final class Repository implements RepositoryInterface
{
    public function __construct(
        private readonly DatabaseSqlInterface $database
    ) {
    }

    public function getById(Id $id): AudioDto
    {
        $query  = $this->getByIdQuery();
        $params = [$id()];

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        $count = count($rows);
        if ($count === 0) {
            throw new NoSuchAudioException(sprintf(
                'Audio with id %s not exist',
                (string) $id
            ));
        }
        if ($count > 1) {
            throw new RepositoryException(sprintf(
                'Audio with id %s has duplicates',
                (string) $id
            ));
        }

        $rawAudio = $rows[0];

        return $this->createFromRow($rawAudio);
    }

    /** @param array<string,string> $row */
    private function createFromRow(array $row): AudioDto
    {
        $rawIdentifier = $row['identifier'] ?? null;
        if ($rawIdentifier === null) {
            throw new RepositoryException('Audio id is invalid');
        }

        $rawActive = $row['active'] ?? null;
        if ($rawActive === null) {
            throw new RepositoryException('Audio active is invalid');
        }
        if ($rawActive === 't') {
            $active = true;
        } else {
            $active = false;
        }

        $rawName = $row['name'] ?? null;
        if ($rawName === null) {
            throw new RepositoryException('Audio name is invalid');
        }

        $rawArticles = $row['articles'] ?? null;
        if ($rawArticles === null) {
            throw new RepositoryException('Audio articles is invalid');
        }

        $articles = $this->createArticles($rawArticles);

        $translates = $this->createTranslates($rawIdentifier);

        return new AudioDto(
            Id::fromString($rawIdentifier),
            $active,
            new Name($rawName),
            $articles,
            $translates
        );
    }

    /** @return array<int,ArticleId> */
    private function createArticles(string $rawArticles): array
    {
        $decodedArticles = json_decode($rawArticles);

        $data = [];
        foreach ($decodedArticles as $article) {
            $data[] = new ArticleId($article);
        }
        return $data;
    }

    /** @return array<int,Translate> */
    protected function createTranslates(string $rawAudioId): array
    {
        $translates = [];

        $params = [$rawAudioId];
        $query  = $this->translatesQuery();

        try {
            $rows = $this->database->queryParams($query, $params);
        } catch (QueryException $e) {
            throw new RepositoryException($e->getMessage());
        }

        foreach ($rows as $row) {
            $rawLanguage = $row['language'] ?? null;
            if ($rawLanguage === null) {
                throw new RepositoryException('Audio translates language param is invalid');
            }
            $rawDescription = $row['description'] ?? null;
            if ($rawDescription === null) {
                throw new RepositoryException('Audio translates description param is invalid');
            }
            $rawPath = $row['path'] ?? null;
            if ($rawPath === null) {
                throw new RepositoryException('Audio translates path param is invalid');
            }

            try {
                $translate    = new Translate(
                    new LanguageId($rawLanguage),
                    new Description($rawDescription),
                    new Path($rawPath)
                );
                $translates[] = $translate;
            } catch (InvalidArgumentException $e) {
                throw new RepositoryException($e->getMessage());
            }
        }

        return $translates;
    }

    private function getByIdQuery(): string
    {
        return <<<'QUERY'
            SELECT audio.identifier,
                audio.active,
                audio.name,
                array_to_json (
                    array (SELECT article.identifier 
                        FROM article
                        WHERE article.audio_id = $1
                    ) 
                ) as articles,
            FROM audio,
            WHERE audio.identifier = $1
        QUERY;
    }

    private function translatesQuery(): string
    {
        return <<<'QUERY'
            SELECT audio_translates.language,
                audio_translates.description,
                audio_translates.path
            FROM audio_translates
            WHERE audio_translates.audio_id = $1
        QUERY;
    }
}
