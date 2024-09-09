<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Server\Api\Results\Http\HttpRouterResultInterface;
use Romchik38\Server\Api\Router\Http\RouterHeadersInterface;
use Romchik38\Server\Results\Http\HttpRouterResult;
use Romchik38\Server\Routers\Http\DynamicHeadersCollection;
use Romchik38\Server\Routers\Http\RouterHeader;

class DynamicHeadersCollectionTest extends TestCase
{
    public function createHeader(string $path, string $method): RouterHeadersInterface
    {
        return new class($path, $method) extends RouterHeader {
            public function setHeaders(HttpRouterResultInterface $result, array $path): void
            {
                $result->setHeaders([
                    ['Cache-Control:no-cache']
                ]);
            }
        };
    }

    /**
     * Adding data to service and testing that it will be returned as expected
     * So, we pass correctly structure to __construct method:
     *   - the method
     *   - the path to a header instance
     *   - the header instance
     * 
     * Also tested getHeader, which returns the header instance
     */
    public function testConstruct()
    {
        $routerResult = new HttpRouterResult();

        $path = 'en<>products';
        $method = 'GET';

        $header = $this->createHeader($path, $method);

        $data = [$header];

        $headerService = new DynamicHeadersCollection($data);
        $result = $headerService->getHeader($method, $path, 'action');
        $result->setHeaders($routerResult, ['en', 'products']);

        $resultHeaders = $routerResult->getHeaders();
        $this->assertSame([['Cache-Control:no-cache']], $resultHeaders);
    }

    /** 
     * 1. Method not found
     */
    public function testGetHeaderMethodNotFound()
    {
        $path = 'en<>products';
        $method = 'GET';

        $header = $this->createHeader($path, $method);
        
        $data = [$header];

        $headerService = new DynamicHeadersCollection($data);
        $result = $headerService->getHeader('POST', $path, 'action');
        $this->assertSame(null, $result);
    }
}
