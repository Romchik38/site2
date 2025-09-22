<?php

declare(strict_types=1);

namespace Romchik38\Tests\Unit\Infrastructure\Http\Views\Html\Classes;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Romchik38\Server\Http\Controller\Path;
use Romchik38\Server\Http\Utils\Urlbuilder\Urlbuilder;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\Query;
use Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\UrlGeneratorUseUrlBuilder;

final class UrlGeneratorUseUrlBuilderTest extends TestCase
{
    public function testGenerateUrl(): void
    {
        $path         = new Path(['root', 'categories']);
        $urlbuilder   = new Urlbuilder();
        $urlGenerator = new UrlGeneratorUseUrlBuilder($path, $urlbuilder);

        $query1  = new Query('cat_id', 'id_1');
        $query2  = new Query('text', 'some_text');
        $queries = [$query1, $query2];

        $url = $urlGenerator->generateUrl($queries);

        $this->assertSame('/categories?cat_id=id_1&text=some_text', $url);
    }

    public function testGenerateUrlThrowsErrorInvalidQuery(): void
    {
        $path         = new Path(['root', 'categories']);
        $urlbuilder   = new Urlbuilder();
        $urlGenerator = new UrlGeneratorUseUrlBuilder($path, $urlbuilder);

        $query1  = '';
        $queries = [$query1];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param query is invalid');

        $urlGenerator->generateUrl($queries);
    }

    public function testGenerateUrlWithSpecialChars(): void
    {
        $path = new Path(['root', 'categories']);
        $urlbuilder = new Urlbuilder();
        $urlGenerator = new UrlGeneratorUseUrlBuilder($path, $urlbuilder);

        $query1 = new Query('cat_id', 'id_1');
        $query2 = new Query('text', 'so\'me text');
        $queries = [$query1, $query2];

        $url = $urlGenerator->generateUrl($queries);

        $this->assertSame('/categories?cat_id=id_1&text=so%27me+text', $url);
    }
}
