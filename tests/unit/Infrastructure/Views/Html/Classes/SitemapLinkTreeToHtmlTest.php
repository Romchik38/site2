<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Server\Controllers\Controller;
use Romchik38\Server\Services\Mappers\ControllerTree\ControllerTree;
use Romchik38\Server\Services\Mappers\LinkTree\Http\LinkTree;
use Romchik38\Site2\Infrastructure\Views\Html\Classes\SitemapLinkTreeToHtml;

class SitemapLinkTreeToHtmlTest extends TestCase
{
    protected $sitemap;
    protected $linkTreeMapper;

    public function setUp(): void
    {
        $this->sitemap        = new ControllerTree();
        $this->linkTreeMapper = new LinkTree();
    }

    public function testGetSitemapLinkTree()
    {
        $controllerRoot  = new Controller('root', true);
        $controllerAbout = new Controller('about', true);
        $controllerRoot->setChild($controllerAbout);

        $sitemapLinkTreeToHtml = new SitemapLinkTreeToHtml(
            $this->sitemap,
            $this->linkTreeMapper
        );

        $row1start  = '<li><a href="/" title="home">home</a>';
        $row1end    = '</li>';
        $row2       = '<ul><li><a href="/about" title="about">about</a></li></ul>';
        $rowsOutput = sprintf('%s%s%s', $row1start, $row2, $row1end);
        $output     = sprintf('<ul>%s</ul>', $rowsOutput);

        $sitemapOutput = $sitemapLinkTreeToHtml->getSitemapLinkTree($controllerRoot, '');

        $this->assertSame($output, $sitemapOutput);
    }
}
