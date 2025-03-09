<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Login;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractMultiLanguageAction;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Login\DefaultAction\ViewDTO;
use Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface;

/** @todo implement it */
final class DefaultAction extends AbstractMultiLanguageAction implements DefaultActionInterface
{
    public function __construct(
        DynamicRootInterface $dynamicRootService,
        TranslateInterface $translateService,
        protected readonly Site2SessionInterface $session,
        protected readonly ViewInterface $view
    )
    {
        parent::__construct($dynamicRootService, $translateService);
    }
    
    public function execute(): ResponseInterface
    {
        $user = $this->session->getData(Site2SessionInterface::USER_FIELD);
        $message = (string )$this->session->getData(Site2SessionInterface::MESSAGE_FIELD);
        if ($message !== '') {
            $this->session->setData(Site2SessionInterface::MESSAGE_FIELD, '');
        }
        $html = $this->view
            ->setController($this->controller)
            ->setControllerData(
                new ViewDTO(
                    'User login', 
                    'User login page', 
                    $user,
                    $message
                )
            )
            ->toString();

        return new HtmlResponse($html);
    }

    public function getDescription(): string
    {
        return 'User login page';
    }
}