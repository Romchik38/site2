<?php

declare(strict_types=1);

namespace Romchik38\Site2\Views\Html;

use Romchik38\Server\Api\Controllers\Actions\ActionInterface;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
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
        if ($this->controller === null) {
            throw new ViewBuildException('Controller was not set. View build aborted');
        }

        $templateControllerName = $this->controller->getName();
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

            if (strlen($templateActionName) > 0) {
                $context['template_action_name'] = $templateActionName;
            }

            $this->beforeRender($context);

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

    protected function setMetadata(string $key, mixed $value): TwigView
    {
        $this->metaData[$key] = $value;
        return $this;
    }

    /** Use this to add custom logic */
    protected function prepareMetaData(): void
    {
        /** 
         *   1. use $this->setMetadata(string $key, string $value)
         *   2. meta_data will be avalible in a template
         * */
    }

    /** 
     * use this tho add specific data to context 
     * 
     * @param array<string,mixed> &$context Twig context
     * @return array<string,mixed> Twig context
     */
    protected function beforeRender(array &$context): array
    {
        /** 
         * $context['key'] = 'value';
         */
        return $context;
    }
}
