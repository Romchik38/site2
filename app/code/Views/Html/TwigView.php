<?php

declare(strict_types=1);

namespace Romchik38\Site2\Views\Html;

use Romchik38\Server\Api\Controllers\Actions\ActionInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\SitemapInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use \Romchik38\Server\Api\Views\Http\HttpViewInterface;
use Romchik38\Server\Views\Http\Errors\ViewBuildException;
use Romchik38\Server\Views\View;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class TwigView extends View implements HttpViewInterface
{
    /**
     * @var array<string,mixed> $metaData
     */
    protected array $metaData = [];

    /**
     * @param string $layoutPath Template to render
     */
    public function __construct(
        protected readonly Environment $environment,
        protected readonly DynamicRootInterface|null $dynamicRootService = null,
        protected readonly TranslateInterface|null $translateService = null,
        protected readonly string $layoutPath = 'base.twig',
    ) {}

    /** 
     *  Creates a view response
     * 
     * @throws ViewBuildException
     */
    public function toString(): string
    {
        /** 1. check view is ready to build */
        if ($this->controllerData === null) {
            throw new ViewBuildException('Controller data was not set. View build aborted');
        }

        /** 2. prepare metada if needed */
        $this->prepareMetaData();

        /** 3. create a view */
        return $this->build();
    }

    protected function build(): string
    {
        $templateControllerName = $this->getControllerTemplatePrefix();
        $templateActionType = '';
        $templateActionName = '';

        /** 3. choose a template path by given action name */
        if (strlen($this->action) > 0) {
            $templateActionType = ActionInterface::TYPE_DYNAMIC_ACTION;
            $templateActionName = $this->action;
        } else {
            $templateActionType = ActionInterface::TYPE_DEFAULT_ACTION;
        }

        /** 4. render */
        try {
            $context = [
                'data' => $this->controllerData,
                'meta_data' => $this->metaData,
                'template_controller_name' => $templateControllerName,
                'template_action_type' => $templateActionType
            ];

            if ($this->translateService !== null) {
                $context['translate'] = $this->translateService;
            }

            if (strlen($templateActionName) > 0) {
                $context['template_action_name'] = $templateActionName;
            }

            $html = $this->environment->render(
                $this->layoutPath,
                $context
            );
        } catch (LoaderError $e) {
            throw new ViewBuildException('Twig Loader error: ' . $e->getMessage() .  '. View build aborted');
        } catch (RuntimeError $e) {
            throw new ViewBuildException('Twig Runtime error: ' . $e->getMessage() .  '. View build aborted');
        } catch (SyntaxError $e) {
            throw new ViewBuildException('Twig Syntax error: ' . $e->getMessage() .  '. View build aborted');
        }

        return $html;
    }

    protected function getControllerTemplatePrefix(): string
    {
        if ($this->controller === null) {
            throw new ViewBuildException('Controller was not set. View build aborted');
        }

        $templateName = $this->controller->getName();

        /** 1. Permanent root */
        if ($this->dynamicRootService === null) {
            return $templateName;
        }

        /**2. replace dynamic root with permanent */
        $currentRoot = $this->dynamicRootService->getCurrentRoot()->getName();
        if ($templateName === $currentRoot) {
            $templateName = SitemapInterface::ROOT_NAME;
        }

        return $templateName;
    }

    /** Use this to add custom logic */
    protected function prepareMetaData(): void
    {
        /** 
         *   1. use $this->setMetadata(string $key, string $value)
         *   2. meta_data will be avalible in a template
         * */
    }

    protected function setMetadata(string $key, mixed $value): TwigView
    {
        $this->metaData[$key] = $value;
        return $this;
    }
}
