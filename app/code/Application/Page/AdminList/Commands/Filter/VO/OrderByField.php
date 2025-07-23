<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\AdminList\Commands\Filter\VO;

use InvalidArgumentException;
use Romchik38\Server\Domain\VO\Text\Text;

use function in_array;
use function sprintf;

final class OrderByField extends Text
{
    public const NAME = 'page order by field';

    public const DEFAULT_ORDER_BY = 'active';
    public const ALLOWED_ORDER_BY = ['id', 'active', 'url'];

    /** @throws InvalidArgumentException */
    public function __construct(
        string $orderByField,
    ) {
        if ($orderByField === '') {
            $orderByField = $this::DEFAULT_ORDER_BY;
        } else {
            if (in_array($orderByField, $this::ALLOWED_ORDER_BY) === false) {
                throw new InvalidArgumentException(
                    sprintf('param %s %s is invalid', $this::NAME, $orderByField)
                );
            }
        }
        parent::__construct($orderByField);
    }
}
