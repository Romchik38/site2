<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Server\Services\Breadcrumb\Http\Breadcrumb;
use Romchik38\Server\Services\Sitemap\Sitemap;
use Romchik38\Server\Models\DTO\Html\Breadcrumb\BreadcrumbDTOFactory;
use Romchik38\Site2\Models\DTO\Html\Link\LinkDTOCollectionUseVirtualRepository;
use Romchik38\Server\Services\DynamicRoot\DynamicRoot;
use Romchik38\Server\Models\DTO\Html\Link\LinkDTOFactory;
use Romchik38\Site2\Models\Link\Sql\LinkRepository;
use Romchik38\Server\Models\Sql\DatabasePostgresql;
use Romchik38\Site2\Models\Link\LinkFactory;


class BreadcrumbTest extends TestCase
{

    protected $dynamicRootForCollection;
    protected $database;
    protected $sitemap;
    protected $dynamicRootForBreadcrumb;

    public function setUp(): void
    {
        $this->dynamicRootForCollection = $this->createMock(DynamicRoot::class);
        $this->sitemap = $this->createMock(Sitemap::class);
        $this->dynamicRootForBreadcrumb = $this->createMock(DynamicRoot::class);
        $this->database = $this->createMock(DatabasePostgresql::class);
    }

    public function testGetBreadcrumbDTOWithoutDynamicRoot()
    {
        $breadcrumb = new Breadcrumb(
            $this->sitemap,
            new BreadcrumbDTOFactory,
            $this->createLinkDTOCollectionUseVirtualRepository()
        );
    }

    protected function createLinkDTOCollectionUseVirtualRepository()
    {

        return new LinkDTOCollectionUseVirtualRepository(
            new LinkDTOFactory(),
            new LinkRepository(
                $this->database,
                new LinkFactory(),
                ['links.path', 'links_translates.*'],
                ['links', 'links_translates']
            ),
            $this->dynamicRootForCollection
        );
    }
}
