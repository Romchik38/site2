<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Sitemap\DefaultAction;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Site2\Application\Page\View\View\PageDto;

/**
 * Created in the Sitemap action. Used in a View template.
 * Use SitemapDTOFactory to create an entity
 *
 * @internal
 */
final class ViewDTO extends DefaultViewDTO
{
    public const OUTPUT_FIELD = 'output';

    public function __construct(
        string $name,
        string $description,
        private string $output,
        public readonly PageDto $page
    ) {
        parent::__construct($name, $description);
    }

    /**
     * @return string html link tree
     */
    public function getOutput(): string
    {
        return $this->output;
    }
}
