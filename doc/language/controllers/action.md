# Action

Use this insude an action

```php
    public function execute(): string
    {
        /** 
         * Use this for database requiest
         * */
        $currentLanguage = $this->DynamicRootService->getCurrentRoot();
        /*
        *  do request to database with $currentLanguage
        */

        /** 
         * Use this to get translated string by given key
         */
        $messageKey = 'root.page_name';
        $translatedMessage = $this->translateService->t($messageKey);
        
        return $translatedMessage;
    } 
```
