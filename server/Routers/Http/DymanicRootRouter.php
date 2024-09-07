<?php

declare(strict_types=1);

namespace Romchik38\Server\Routers\Http;

use Romchik38\Server\Api\Controllers\Actions\ActionInterface;
use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Results\Http\HttpRouterResultInterface;
use Romchik38\Server\Api\Router\Http\HttpRouterInterface;
use Romchik38\Server\Api\Services\Redirect\Http\RedirectInterface;
use Romchik38\Server\Controllers\Errors\NotFoundException;
use Romchik38\Server\Api\Router\Http\RouterHeadersInterface;
use Romchik38\Server\Api\Services\DymanicRoot\DymanicRootInterface;
use Romchik38\Server\Api\Services\Request\Http\RequestInterface;
use Romchik38\Server\Routers\Errors\RouterProccessError;

class DymanicRootRouter implements HttpRouterInterface
{
    protected array $headers;

    public function __construct(
        protected HttpRouterResultInterface $routerResult,
        protected RequestInterface $request,
        protected DymanicRootInterface $dynamicRootService,
        protected array $actionListCallback,
        array $headers = [],
        protected ControllerInterface | null $notFoundController = null,
        protected RedirectInterface|null $redirectService = null
    ) {
        $this->headers = $headers[$request->getMethod()] ?? [];
    }
    public function execute(): HttpRouterResultInterface
    {
        // 0. define
        $uri = $this->request->getUri();
        $scheme = $uri->getScheme();
        $host = $uri->getHost();
        $method = $this->request->getMethod();
        $path = $uri->getPath();
        [$url] = explode('?', $path);

        $defaultRoot = $this->dynamicRootService->getDefaultRoot();
        $rootList = $this->dynamicRootService->getRootNames();

        // 1. parse url
        $elements = explode('/', $url);

        // two blank elements for /
        if (count($elements) === 2 && $elements[0] === '' && $elements[1] === '') {
            $elements = [''];
        }

        // delete first blank item
        array_shift($elements);

        // 2. for / redirect to default root
        if (count($elements) === 0) {
            return $this->routerResult->setHeaders([[
                'Location: ' . $scheme . RedirectInterface::SCHEME_HOST_DELIMITER
                    . $host . '/' . $defaultRoot->getName(),
                true,
                301
            ]]);
        }

        $rootName = $elements[0];

        // 3. try to redirect to defaultRoot + path
        if (array_search($rootName, $rootList, true) === false) {
            return $this->routerResult->setHeaders([[
                'Location: ' . $scheme . RedirectInterface::SCHEME_HOST_DELIMITER
                    . $host . '/' . $defaultRoot->getName() . $path,
                true,
                301
            ]]);
        }

        // 4. Create a dynamic root
        /** @todo replace callback with class */
        $controllers = ($this->actionListCallback[0])($rootName);

        // 5. method check 
        if (array_key_exists($method, $controllers) === false) {
            return $this->methodNotAllowed($controllers);
        }

        // 6. redirect check
        if ($this->redirectService !== null) {
            $redirectResult = $this->redirectService->execute($url, $method);
            if ($redirectResult !== null) {
                return $this->routerResult->setHeaders([
                    [
                        'Location: ' . $scheme . RedirectInterface::SCHEME_HOST_DELIMITER
                            . $host . $redirectResult->getRedirectLocation(),
                        true,
                        $redirectResult->getStatusCode()
                    ]
                ]);
            }
        }

        /**
         * 7. set current root
         * 
         * - the check may be ommited, because early we did check #3 with $rootList
         *   and redirected all requests which starts with items not in the $rootList 
         * - but we can't set $rootName which is not in the list because of something ...
         * - so there is the check:
         */
        $isSetCurrentRoot = $this->dynamicRootService->setCurrentRoot($rootName);
        if ($isSetCurrentRoot === false) {
            throw new RouterProccessError('Can\'t set current dynamic root with name: ' . $rootName);
        }

        /** @var ControllerInterface $rootController */
        $rootController = $controllers[$method];

        // 8. Exec
        try {
            $controllerResult = $rootController->execute($elements);

            $path = $controllerResult->getPath();
            $response = $controllerResult->getResponse();
            $type = $controllerResult->getType();

            $this->routerResult->setStatusCode(200)->setResponse($response);
            return $this->setHeaders($path, $type);
        } catch (NotFoundException $e) {
            return $this->pageNotFound();
        }
    }

    /**
     * set the result to 405 - Method Not Allowed
     */
    protected function methodNotAllowed(array $controllers): HttpRouterResultInterface
    {
        $this->routerResult->setResponse(HttpRouterResultInterface::METHOD_NOT_ALLOWED_RESPONSE)
            ->setHeaders([
                [
                    'Allow:' . implode(', ', array_keys($controllers)),
                    true,
                    HttpRouterResultInterface::METHOD_NOT_ALLOWED_CODE
                ]
            ]);
        return $this->routerResult;
    }

    /**
     * set the result to 404 - Not Found
     */
    protected function pageNotFound(): HttpRouterResultInterface
    {
        $response = HttpRouterResultInterface::NOT_FOUND_RESPONSE;
        if ($this->notFoundController !== null) {
            $response = $this->notFoundController->execute(
                [HttpRouterResultInterface::NOT_FOUND_STATUS_CODE]
            )->getResponse();
        }
        $this->routerResult->setStatusCode(HttpRouterResultInterface::NOT_FOUND_STATUS_CODE)
            ->setResponse($response);
        return $this->routerResult;
    }

    /** 
     * set headers for actions
     */
    protected function setHeaders(array $path, string $type): HttpRouterResultInterface
    {
        $pathString = implode(ControllerInterface::PATH_SEPARATOR, $path);
        $header = $this->headers[$pathString] ?? null;

        if ($header === null && $type === ActionInterface::TYPE_DYNAMIC_ACTION) {
            $dynamicPath = array_slice($path, 0, count($path) - 1);
            array_push($dynamicPath, ControllerInterface::PATH_DYNAMIC_ALL);
            $dynamicPathString = implode(ControllerInterface::PATH_SEPARATOR, $dynamicPath);
            $header = $this->headers[$dynamicPathString] ?? null;
        }

        if ($header !== null) {
            /** @var RouterHeadersInterface $header */
            $header->setHeaders($this->routerResult, $path);
        }

        return $this->routerResult;
    }
}
