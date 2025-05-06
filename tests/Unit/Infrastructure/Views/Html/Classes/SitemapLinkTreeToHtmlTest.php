<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Infrastructure\Views\Html\Classes;

use PHPUnit\Framework\TestCase;
use Romchik38\Server\Controllers\Controller;
use Romchik38\Server\Http\Controller\Mappers\ControllerTree\ControllerTree;
use Romchik38\Server\Http\Controller\Mappers\LinkTree\LinkTree;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\SitemapLinkTreeToHtml;

use function sprintf;

final class SitemapLinkTreeToHtmlTest extends TestCase
{
    private ControllerTree $sitemap;
    private LinkTree $linkTreeMapper;

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
