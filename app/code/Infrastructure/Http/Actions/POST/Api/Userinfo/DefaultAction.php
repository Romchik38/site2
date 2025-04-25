<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\POST\Api\Userinfo;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Models\DTO\Api\ApiDTOInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Models\DTO\Api\ApiDTO;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Services\Translate\TranslateInterface;
use Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface;

final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public const MUST_BE_LOGGED_IN_ERROR = 'You must be logged in to make a request';
    public const API_NAME                = 'Api username point';
    public const API_DESCRIPTION         = 'Information about auth user';

    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        protected readonly Site2SessionInterface $session
    ) {
        parent::__construct($dynamicRootService, $translateService);
    }

    public function execute(): ResponseInterface
    {
        $user = $this->session->getData(Site2SessionInterface::USER_FIELD);
        if ($user === null || $user === '') {
            $dto = new ApiDTO(
                $this::API_NAME,
                $this::API_DESCRIPTION,
                ApiDTOInterface::STATUS_ERROR,
                $this::MUST_BE_LOGGED_IN_ERROR
            );
        } else {
            $dto = new ApiDTO(
                $this::API_NAME,
                $this::API_DESCRIPTION,
                ApiDTOInterface::STATUS_SUCCESS,
                $user
            );
        }

        return new JsonResponse($dto);
    }

    public function getDescription(): string
    {
        return 'Api point - Userinfo';
    }
}
