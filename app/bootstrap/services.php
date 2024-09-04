<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Api\Services\Language\LanguageInterface;
use Romchik38\Server\Config\Errors\MissingRequiredParameterInFileError;

return function (Container $container) {

    // LANGUAGE
    $configLanguage = require_once(__DIR__ . '/../config/shared/language.php');
    $defaultLanguage = $configLanguage[LanguageInterface::DEFAULT_LANGUAGE_FIELD] ??
        throw new MissingRequiredParameterInFileError('Missing config field: '
            . LanguageInterface::DEFAULT_LANGUAGE_FIELD);
    $languageList = $configLanguage[LanguageInterface::LANGUAGE_LIST_FIELD] ??
        throw new MissingRequiredParameterInFileError('Missing config field: '
            . LanguageInterface::LANGUAGE_LIST_FIELD);

    $container->add(
        \Romchik38\Server\Services\Language\Language::class,
        new \Romchik38\Server\Services\Language\Language(
            $defaultLanguage,
            $languageList,
            $container->get(\Romchik38\Server\Api\Models\DTO\Language\LanguageDTOFactoryInterface::class)
        )
    );
    $container->add(
        \Romchik38\Server\Api\Services\Language\LanguageInterface::class,
        $container->get(\Romchik38\Server\Services\Language\Language::class)
    );

    return $container;
};
