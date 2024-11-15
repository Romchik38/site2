<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Infrastructure\Persist\Sql\Link\LinkRepository;
use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Site2\Domain\Link\LinkFactory;

class LinkRepositoryTest extends TestCase
{
    protected $database;
    protected $factory;

    public function setUp(): void
    {
        $this->database = $this->createMock(DatabaseInterface::class);
        $this->factory = new LinkFactory;
    }

    public function testGetLinksByLanguageAndPaths()
    {
        $language = 'uk';
        $name = 'Головна';
        $description = 'Головна сторінка';
        $linkId = '1';

        $paths = [['root'], ['root', 'about']];

        $model1 = [
            'path' => ['root'],
            'link_id' => $linkId,
            'language' => $language,
            'name' => $name,
            'description' => $description
        ];

        $expression = 'SELECT links.path, links_translates.* FROM links, links_translates WHERE links.link_id = links_translates.link_id AND links_translates.language = $1 AND (links.path = $2 OR links.path = $3)';

        $this->database->expects($this->once())->method('queryParams')->with(
            $expression,
            ['uk', '{"root"}', '{"root","about"}']
        )->willReturn([$model1]);

        $repository = new LinkRepository(
            $this->database,
            $this->factory,
            ['links.path', 'links_translates.*'],
            ['links', 'links_translates']
        );

        $res = $repository->getLinksByLanguageAndPaths($language, $paths);

        $this->assertSame(1, count($res));

        /** @var Link $model*/
        $model = $res[0];

        $this->assertSame($language, $model->getLanguage());
        $this->assertSame($name, $model->getName());
        $this->assertSame($description, $model->getDescription());
        $this->assertSame((int)$linkId, $model->getId());
    }
}
