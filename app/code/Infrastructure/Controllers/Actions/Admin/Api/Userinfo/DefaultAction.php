<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\Admin\Api\Userinfo;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\SessionInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;

final class DefaultAction extends AbstractMultiLanguageAction 
    implements DefaultActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        protected readonly SessionInterface $session
    )
    {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(): ResponseInterface
    {
        return new JsonResponse('api user info');
    }

    public function getDescription(): string
    {
        return 'Admin api point - Userinfo';
    }
}