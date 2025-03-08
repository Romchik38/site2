<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Api\Userinfo;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Models\DTO\Api\ApiDTOInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Models\DTO\Api\ApiDTO;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface;

final class DefaultAction extends AbstractMultiLanguageAction 
    implements DefaultActionInterface
{
    const MUST_BE_LOGGED_IN_ERROR = 'You must be logged in to make a request';
    const API_NAME = 'Admin api username point';
    const API_DESCRIPTION = 'Information about auth admin user';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        protected readonly Site2SessionInterface $session
    )
    {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(): ResponseInterface
    {
        $adminUser = $this->session->getData(Site2SessionInterface::ADMIN_USER_FIELD);
        if ($adminUser === null || $adminUser === '') {
            $dto = new ApiDTO(
                $this::API_NAME,
                $this::API_DESCRIPTION,
                ApiDTOInterface::STATUS_ERROR,
                $this::MUST_BE_LOGGED_IN_ERROR
            );
        }
        $dto = new ApiDTO(
            $this::API_NAME,
            $this::API_DESCRIPTION,
            ApiDTOInterface::STATUS_SUCCESS,
            $adminUser
        );

        return new JsonResponse($dto);
    }

    public function getDescription(): string
    {
        return 'Admin api point - Userinfo';
    }
}