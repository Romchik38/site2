<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\ServerErrorExample;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Http\Controller\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Http\Controller\Actions\DefaultActionInterface;

/** Tries to show nice answer */
final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public const DEFAULT_VIEW_NAME = 'server-error-example.page_name';

    public function execute(): ResponseInterface
    {
        throw new Exception('Example server error occurred');
    }

    public function getDescription(): string
    {
        return $this->translateService->t($this::DEFAULT_VIEW_NAME);
    }
}
