<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Romchik38\Server\Api\Results\Http\HttpRouterResultInterface;
use Romchik38\Server\Routers\Http\DymanicRootRouter;
use Romchik38\Server\Results\Http\HttpRouterResult;
use Romchik38\Server\Services\Request\Http\Request;
use Romchik38\Server\Services\DymanicRoot\DymanicRoot;
use Romchik38\Server\Controllers\Controller;
use Romchik38\Server\Services\Request\Http\Uri;
use Romchik38\Server\Models\DTO\DymanicRoot\DymanicRootDTO;

class DymanicRootRouterTest extends TestCase
{

    protected $routerResult;
    protected $request;
    protected $dynamicRootService;
    protected $controller;

    public function setUp(): void
    {
        $this->routerResult = $this->createMock(HttpRouterResult::class);
        $this->request = $this->createMock(Request::class);
        $this->dynamicRootService = $this->createMock(DymanicRoot::class);
        $this->controller = $this->createMock(Controller::class);
    }

    /**
     * #2 comment in the source code
     * Redirect from "/" to "/en"
     */
    public function testExecuteRedirectToDefaultRootFromSlash()
    {
        $uri = new Uri('http', 'example.com', '/');
        $defaultRootDTO = new DymanicRootDTO('en');
        $rootNames = ['en', 'uk'];

        $this->request->expects($this->once())->method('getUri')->willReturn($uri);
        $this->request->method('getMethod')->willReturn('GET');

        $this->dynamicRootService->expects($this->once())->method('getDefaultRoot')
            ->willReturn($defaultRootDTO);

        $this->dynamicRootService->expects($this->once())->method('getRootNames')
            ->willReturn($rootNames);

        $this->routerResult->expects($this->once())->method('setHeaders')
            ->with([['Location: http://example.com/en', true, 301]]);

        $router = new DymanicRootRouter(
            $this->routerResult,
            $this->request,
            $this->dynamicRootService,
            ['GET' => $this->controller]
        );

        $router->execute();
    }

    /**
     * #3 comment in the source code
     *  Try to redirect from "/path" to "defaultRoot + path"
     */
    public function testExecuteRedirectToDefaultRootPlusPathFromSlashPath()
    {
        $uri = new Uri('http', 'example.com', '/products');
        $defaultRootDTO = new DymanicRootDTO('en');
        $rootNames = ['en', 'uk'];

        $this->request->expects($this->once())->method('getUri')->willReturn($uri);
        $this->request->method('getMethod')->willReturn('GET');

        $this->dynamicRootService->expects($this->once())->method('getDefaultRoot')
            ->willReturn($defaultRootDTO);

        $this->dynamicRootService->expects($this->once())->method('getRootNames')
            ->willReturn($rootNames);

        $this->routerResult->expects($this->once())->method('setHeaders')
            ->with([['Location: http://example.com/en/products', true, 301]]);

        $router = new DymanicRootRouter(
            $this->routerResult,
            $this->request,
            $this->dynamicRootService,
            ['GET' => $this->controller]
        );

        $router->execute();
    }

    /**
     * #5 comment in the source code
     * Method not Allowed
     */

    public function testExecuteMethodNotAllowed()
    {
        $uri = new Uri('http', 'example.com', '/en/products');
        $defaultRootDTO = new DymanicRootDTO('en');
        $rootNames = ['en', 'uk'];

        $this->request->method('getUri')->willReturn($uri);
        $this->request->method('getMethod')->willReturn('PUT');

        $this->dynamicRootService->method('getDefaultRoot')
            ->willReturn($defaultRootDTO);

        $this->dynamicRootService->method('getRootNames')
            ->willReturn($rootNames);

        $this->routerResult->expects($this->once())->method('setResponse')
            ->with(HttpRouterResultInterface::METHOD_NOT_ALLOWED_RESPONSE)
            ->willReturn($this->routerResult);

        $this->routerResult->expects($this->once())->method('setHeaders')
            ->with([['Allow:GET', true, HttpRouterResultInterface::METHOD_NOT_ALLOWED_CODE]]);

        $router = new DymanicRootRouter(
            $this->routerResult,
            $this->request,
            $this->dynamicRootService,
            [function () {
                return ['GET' => $this->controller];
            }]
        );

        $router->execute();
    }
}
