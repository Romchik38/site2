<?php

declare(strict_types=1);

namespace Romchik38\Server\Views\Http;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\SitemapInterface;
use \Romchik38\Server\Api\Views\Http\HttpViewInterface;
use Romchik38\Server\Views\Http\Errors\ViewBuildException;
use Twig\Environment;
use Twig\Error\LoaderError;

class TwigView implements HttpViewInterface
{
    protected DefaultViewDTOInterface $controllerData;
    protected array $metaData = [];
    protected ControllerInterface|null $controller = null;
    protected string $action;

    public function __construct(
        protected Environment $environment,
        protected DynamicRootInterface $dynamicRootService,
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

    /** 
     *  Creates a view response
     * 
     * @todo move to interface
     * @throws ViewBuildException
     */
    public function toString(): string
    {
        $this->prepareMetaData($this->controllerData);
        return $this->build();
    }

    /** @todo check */
    protected function build(): string
    {
        /** 1. check view is ready to build */
        if ($this->controller === null || $this->action === null) {
            throw new ViewBuildException('Controller was not set. View build aborted');
        }

        $templateName = $this->controller->getName();
        /**2. replace dynamic root with permanent */
        $currentRoot = $this->dynamicRootService->getCurrentRoot()->getName();
        if ($templateName === $currentRoot) {
            $templateName = SitemapInterface::ROOT_NAME;
        }

        /** 3. choose a template path by given action name */
        if (strlen($this->action) > 0) {
            $templateName .= '/dynamic/' . $this->action . '.twig';
        } else {
            $templateName .= '/default/index.twig';
        }

        /** 4. render */
        try {
            $html = $this->environment->render($templateName);
        } catch(LoaderError $e) {
            /** @todo log errror */
            throw new ViewBuildException('Template render error. View build aborted');
        }

        return $html;
    }

    /** @todo check */
    protected function prepareMetaData(DefaultViewDTOInterface $data): void
    {
        /** use this for add info to metaData */
    }
}
