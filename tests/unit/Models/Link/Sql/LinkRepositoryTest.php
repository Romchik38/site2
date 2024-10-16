<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Site2\Models\Link\Sql\LinkRepository;
use Romchik38\Server\Models\Sql\DatabasePostgresql;
use Romchik38\Site2\Models\Link\Link;
use Romchik38\Site2\Models\Link\LinkFactory;

class LinkRepositoryTest extends TestCase
{
    protected $database;
    protected $factory;

    public function setUp(): void
    {
        $this->database = $this->createMock(DatabasePostgresql::class);
        $this->factory = $this->createMock(LinkFactory::class);
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
        // SELECT links.path, links_translates.* FROM links, links_translates WHERE links_translates.language = 'uk' AND links.path = '{"root"}' OR links.path = '{"root","about"}';
        $expression = 'SELECT links.path, links_translates.* FROM links, links_translates WHERE links_translates.language = $1 AND links.path = $2 OR links.path = $3';

        $this->database->expects($this->once())->method('queryParams')->with(
            $expression,
            ['uk', '\'{"root"}\'', '\'{"root","about"}\'']
        )->willReturn([$model1]);

        $this->factory->method('create')->willReturn(new Link());

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
