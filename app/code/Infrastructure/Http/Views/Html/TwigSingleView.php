<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Views\Html;

use Romchik38\Server\Http\Views\AbstractSingleView;
use Romchik38\Server\Http\Views\Errors\ViewBuildException;
use Romchik38\Server\Http\Views\MetaDataInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class TwigSingleView extends AbstractSingleView
{
    /**
     * @param string $layoutPath Template to render
     */
    public function __construct(
        protected readonly Environment $environment,
        protected readonly string $layoutPath = 'base.twig',
        ?MetaDataInterface $metaDataService = null
    ) {
        parent::__construct($metaDataService);
    }

    /**
     *  Creates a view response
     *
     * @throws ViewBuildException
     */
    public function toString(): string
    {
        /** 1. check view is ready to build */
        if ($this->handlerData === null) {
            throw new ViewBuildException('Handler data was not set. View build aborted');
        }

        /** 2. prepare metada if needed */
        $this->prepareMetaData();

        /** 3. create a view */
        return $this->build();
    }

    protected function build(): string
    {
        /** 4. render */
        try {
            $context = [
                'data'      => $this->handlerData,
                'meta_data' => $this->metaData,
            ];

            $this->beforeRender($context);

            $html = $this->environment->render(
                $this->layoutPath,
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
