<?php

declare(strict_types=1);

namespace Romchik38\Server\Views\Http;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOInterface;
use \Romchik38\Server\Api\Views\Http\HttpViewInterface;
use Twig\Environment;

class TwigView implements HttpViewInterface
{
    protected DefaultViewDTOInterface $controllerData;
    protected array $metaData = [];
    protected ControllerInterface|null $controller = null;
    protected string $action;

    public function __construct(
        protected Environment $environment,
        protected string $controllerPath = 'controllers',
        protected string $layoutPath = 'layouts'
    ) {}

    /** @todo check */
    public function setController(ControllerInterface $controller, string $action = ''): HttpViewInterface
    {
        $this->controller = $controller;
        $this->action = $action;
        return $this;
    }

    /** @todo check */
    public function setControllerData(DefaultViewDTOInterface $data): HttpViewInterface
    {
        $this->controllerData = $data;
        return $this;
    }

    /** @todo check */
    public function setMetadata(string $key, string $value): HttpViewInterface
    {
        $this->metaData[$key] = $value;
        return $this;
    }

    /** @todo check */
    public function toString(): string
    {
        $this->prepareMetaData($this->controllerData);
        return $this->build();
    }

    /** @todo check */
    protected function build(): string
    {

        $html = '';

        return $html;
    }

    /** @todo check */
    protected function prepareMetaData(DefaultViewDTOInterface $data): void
    {
        /** use this for add info to metaData */
    }
}
