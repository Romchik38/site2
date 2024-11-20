<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Img;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\Request\Http\ServerRequestInterface;
use Romchik38\Server\Controllers\Actions\Action;
use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Site2\Infrastructure\Controllers\Img\DefaultAction\ImgData;

final class DefaultAction extends Action implements DefaultActionInterface
{

    public function __construct(
        protected readonly ServerRequestInterface $request,
    ) {}

    public function execute(): string
    {
        $requestData = $this->request->getQueryParams();

        /** 1. create command object */
        try {
            $imgData = ImgData::fromRequest($requestData);
        } catch (InvalidArgumentException $e) {
            /** @todo implement BadRequestException */
            //return 'bad request';
            return $e->getMessage();
        }


        return json_encode($_SERVER);
    }

    public function getDescription(): string
    {
        return 'Images';
    }
}
