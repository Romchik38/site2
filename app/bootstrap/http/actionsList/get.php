<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Services\Mappers\ControllerTreeInterface;
use Romchik38\Server\Controllers\Controller;

return function (Container $container): ControllerInterface {
    /** ROOT */
    $root = new Controller(
        ControllerTreeInterface::ROOT_NAME,
        true,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Root\DefaultAction'),
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Root\DynamicAction'),
    );

    /** API */
    $api = new Controller('api');

    /** SITEMAP */
    $sitemap = new Controller(
        'sitemap',
        true,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Sitemap\DefaultAction')
    );

    /** SERVER-ERROR example */
    $serverErrorExample = new Controller(
        'server-error-example',
        true,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\ServerErrorExample\DefaultAction')
    );

    /** ARTICLE */
    $article = new Controller(
        'article',
        true,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Article\DefaultAction'),
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Article\DynamicAction')
    );

    /** ADMIN */
    $admin = new Controller(
        'admin',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\DefaultAction')
    );
    $admin->addRequestMiddleware($container->get('\Romchik38\Site2\Infrastructure\Controllers\RequestMiddlewares\Admin\AdminLoginMiddleware'));

    $adminAudio = new Controller(
        'audio',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Audio\DefaultAction'),
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Audio\DynamicAction')
    );
    $adminAudioNew = new Controller(
        'new',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Audio\New\DefaultAction'),
        null,
        'audio_new'
    );
    $adminAudioTranslate = new Controller(
        'translate',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Audio\Translate\DefaultAction'),
        null,
        'audio_translate'
    );
    $adminAudio
    ->setChild($adminAudioNew)
    ->setChild($adminAudioTranslate);

    $adminUsers = new Controller(
        'users',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Users\DefaultAction')
    );
    $adminUsers->addRequestMiddleware($container->get('Romchik38\Site2\Infrastructure\Controllers\RequestMiddlewares\Admin\AdminRolesMiddleware'));

    $adminArticle = new Controller(
        'article',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Article\DefaultAction')
    );

    $adminImagecache = new Controller(
        'imagecache',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Imagecache\DefaultAction')
    );

    $adminImage = new Controller(
        'image',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Image\DefaultAction'),
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Image\DynamicAction')
    );
    $adminImageNew = new Controller(
        'new',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Image\New\DefaultAction'),
        null,
        'image_new'
    );
    $adminImage->setChild($adminImageNew);

    $adminAuthor = new Controller(
        'author',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Author\DefaultAction'),
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Author\DynamicAction')
    );
    $adminAuthorNew = new Controller(
        'new',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Author\New\DefaultAction'),
        null,
        'author_new'
    );
    $adminAuthor->setChild($adminAuthorNew);

    $adminLanguage = new Controller(
        'language',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Language\DefaultAction')
    );
    
    $adminTranslate = new Controller(
        'translate',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Translate\DefaultAction'),
        $container->get('\\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Translate\DynamicAction')
    );
    $admintranslateNew = new Controller(
        'new',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Translate\New\DefaultAction'),
        null,
        'translate_new'
    );
    $adminTranslate->setChild($admintranslateNew);

    $admin
    ->setChild($adminAudio)
    ->setChild($adminArticle)
    ->setChild($adminAuthor)
    ->setChild($adminImagecache)
    ->setChild($adminImage)
    ->setChild($adminLanguage)
    ->setChild($adminTranslate)
    ->setChild($adminUsers);
    
    /** REGISTER */
    $register = new Controller(
        'register', 
        true,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Register\DefaultAction')
    );

    /** LOGIN */
    $login = new Controller(
        'login', 
        true,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Login\DefaultAction')
    );
    $loginAdmin = new Controller(
        'admin',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Login\Admin\DefaultAction'),
        null,
        'login_admin'
    );
    $login->setChild($loginAdmin);
    
    $root
        ->setChild($api)
        ->setChild($sitemap)
        ->setChild($serverErrorExample)
        ->setChild($article)
        ->setChild($admin)
        ->setChild($register)
        ->setChild($login);
    return $root;
};