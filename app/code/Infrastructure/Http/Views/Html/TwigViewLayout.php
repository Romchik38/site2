<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Views\Html;

use Romchik38\Server\Http\Controller\Actions\ActionInterface;
use Romchik38\Server\Http\Views\Errors\ViewBuildException;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

use function sprintf;
use function strlen;

class TwigViewLayout extends TwigView
{
    protected function build(): string
    {
        if ($this->controller === null) {
            throw new ViewBuildException('Controller was not set. View build aborted');
        }

        $templateControllerName = $this->controller->getId();
        $templateActionType     = '';
        $templateActionName     = '';

        /** 3. choose a template path by given action name */
        if (strlen($this->action) > 0) {
            $templateActionType = ActionInterface::TYPE_DYNAMIC_ACTION;
            $templateActionName = $this->action;
        } else {
            $templateActionType = ActionInterface::TYPE_DEFAULT_ACTION;
        }

        $templateFullPrefix = sprintf(
            '%s/%s/%s/',
            $this->layoutPath,
            $templateControllerName,
            $templateActionType
        );

        /** 4. render */
        try {
            $context = [
                'data'                     => $this->controllerData,
                'meta_data'                => $this->metaData,
                'template_controller_name' => $templateControllerName,
                'template_action_type'     => $templateActionType,
                'template_full_prefix'     => $templateFullPrefix,
            ];

            if (strlen($templateActionName) > 0) {
                $context['template_action_name'] = $templateActionName;
            }

            $this->beforeRender($context);

            $html = $this->environment->render(
                $templateFullPrefix . 'index.twig',
                $context
            );
        } catch (LoaderError $e) {
            throw new ViewBuildException('Twig Loader error: ' . $e->getMessage() . '. View build aborted');
        } catch (RuntimeError $e) {
            throw new ViewBuildException('Twig Runtime error: ' . $e->getMessage() . '. View build aborted');
        } catch (SyntaxError $e) {
            throw new ViewBuildException('Twig Syntax error: ' . $e->getMessage() . '. View build aborted');
        }

        return $html;
    }
}
