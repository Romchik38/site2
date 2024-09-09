<?php

declare(strict_types=1);

namespace Romchik38\Server\Routers\Http;

use Romchik38\Server\Api\Controllers\Actions\ActionInterface;
use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Router\Http\RouterHeadersInterface;
use Romchik38\Server\Api\Routers\Http\DynamicHeadersCollectionInterface;

/** 
 * this is not a service for the app
 * it used only in dynamic header
 */
class DynamicHeadersCollection implements DynamicHeadersCollectionInterface
{
    protected array $hash = [];

    public function __construct(
        array $data
    ) {
        /** 
         * @var array $data key is a method name, value is an array ( see below )
         *  Example:
         * [ 'GET' => [...], 'POST' => [...], ...]
         */
        foreach ($data as $method => $headerList) {
            $headers = [];
            /**
             * @var string $path a path key to identify the header
             * @var RouterHeadersInterface $header an instance of header class
             * Example:
             *  [ 
             *     en<>products => header instance of products,
             *     en           => header instance of root
             *     ...
             *  ]
             * where <> is a separator
             */
            foreach ($headerList as $path => $header) {
                $headers[$path] = $header;
            }
            $this->hash[$method] = $headers;
        }
    }

    public function getHeader(string $method, string $path, string $actionType): RouterHeadersInterface|null
    {
        /** 1. Method not found */
        $headers = $this->hash[$method] ?? null;
        if ($headers === null) {
            return null;
        }

        /** 
         * 2. Default action check 
         * 
         * @var RouterHeadersInterface|null $header
         * */
        $header = $headers[$path] ?? null;
        if ($header !== null) {
            return $header;
        }

        /** 3. Dynamic action check */
        if ($header === null && $actionType === ActionInterface::TYPE_DYNAMIC_ACTION) {
            $path = $path . ControllerInterface::PATH_SEPARATOR
                . ControllerInterface::PATH_DYNAMIC_ALL;
            /** 
             * Example: en<>*
             * where en - root, <> - separator, * - dynamic marker
             * 
             * @var RouterHeadersInterface|null $header
             */
            $header = $headers[$path] ?? null;
        }

        return $header;
    }
}
