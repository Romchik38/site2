<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\Sitemap\DefaultAction;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;

/** 
 * Created in the Sitemap action. Used in a View template.
 * Use SitemapDTOFactory to create an entity
 * 
 * @internal
 */
final class SitemapDTO extends DefaultViewDTO
{
    const OUTPUT_FIELD = 'output';

    public function __construct(
        string $name,
        string $description,
        string $output
    ) {
        parent::__construct($name, $description);
        $this->data[$this::OUTPUT_FIELD] = $output;
    }

    /**
     * @return string html link tree
     */
    public function getOutput(): string
    {
        return $this->data[$this::OUTPUT_FIELD];
    }
}
