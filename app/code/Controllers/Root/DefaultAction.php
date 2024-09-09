<?php

declare(strict_types=1);

namespace Romchik38\Site2\Controllers\Root;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Controllers\Actions\MultiLanguageAction;

class DefaultAction extends MultiLanguageAction implements DefaultActionInterface
{

    public function execute(): string
    {
        /** 
         * this is for database requiest, when we want to get info 
         * for use inside this action
         * */
        $currentRoot = $this->DynamicRootService->getCurrentRoot();

        /** 
         * for the views we do need use $currentRoot,
         *  because it alredy defined in the translate service
         */
        $message = 'root.page_name';
        return $this->translateService->t($message);
    }   
}
