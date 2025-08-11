<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Views\Html;

use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface;
use Twig\Environment;

use function array_map;

class Site2TwigSingleView extends TwigSingleView
{
    protected ?string $message = null;

    public function __construct(
        Environment $environment,
        protected readonly TranslateInterface $translateService,
        protected readonly DynamicRootInterface $dynamicRootService,
        protected readonly UrlbuilderInterface $urlbuilder,
        protected readonly Site2SessionInterface $session,
        string $layoutPath
    ) {
        parent::__construct($environment, $layoutPath);
    }

    protected function prepareMetaData(): void
    {
        $this->prepareLanguages();
        $this->prepareMessage();
    }

    /**
     * Add to metadata:
     *   - current language
     *   - a list of available languages
     */
    protected function prepareLanguages(): void
    {
        $currentRoot = $this->dynamicRootService->getCurrentRoot();
        $languages   = array_map(
            fn($item) => $item->getName(),
            $this->dynamicRootService->getRootList()
        );

        $this->setMetadata('language', $currentRoot->getName())
            ->setMetadata('languages', $languages);
    }

    /** @todo refactor */
    protected function prepareMessage(): void
    {
        $message = (string) $this->session->getData(Site2SessionInterface::MESSAGE_FIELD);
        if ($message !== '') {
            $this->session->setData(Site2SessionInterface::MESSAGE_FIELD, '');
        }
        $this->message = $message;
    }

    /**
     * @param array<string,mixed> &$context Twig context
     * @return array<string,mixed> Twig context
     */
    protected function beforeRender(array &$context): array
    {
        $context['translate']  = $this->translateService;
        $context['urlbuilder'] = $this->urlbuilder;
        $context['message']    = $this->message;
        return $context;
    }
}
