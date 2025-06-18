<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Server\Http\Controller\ControllerInterface;
use Romchik38\Server\Http\Controller\Controller;

return function (Container $container): ControllerInterface {
    /** POST */
    $root = new Controller(ControllerInterface::ROOT_NAME);

    // Auth
    $auth = new Controller(
        'auth', 
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Auth\DefaultAction')
    );
    $auth->addRequestMiddleware($container->get('\Romchik38\Site2\Infrastructure\Http\RequestMiddlewares\CsrfMiddleware'));
    
    $authAdmin = new Controller(
        'admin',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Auth\Admin\DefaultAction'),
        null,
        'auth_admin'
    );
    $auth->setChild($authAdmin);

    // Logout
    $logout = new Controller(
        'logout',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Logout\DefaultAction')
    );

    // Api
    $api = new Controller('api');
    $apiUserinfo = new Controller(
        'userinfo',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Api\Userinfo\DefaultAction')
    );
    $api->setChild($apiUserinfo);

    // Admin
    $admin = new Controller('admin');
    $admin->addRequestMiddleware($container->get('\Romchik38\Site2\Infrastructure\Http\RequestMiddlewares\Admin\AdminLoginMiddleware'));

    // Admin Article
    $adminArticle = new Controller('article', false, null, null, 'admin_article');
    $adminArticleDelete = new Controller(
        'delete',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Article\Delete\DefaultAction'),
        null,
        'article_delete'
    );
    $adminArticleNew = new Controller(
        'new',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Article\New\DefaultAction'),
        null,
        'article_new'
    );
    $adminArticleUpdate = new Controller(
        'update', 
        false, 
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Article\Update\DefaultAction'),
        null, 
        'article_update'
    );
    $adminArticle
    ->setChild($adminArticleDelete)
    ->setChild($adminArticleNew)
    ->setChild($adminArticleUpdate)
    ->addRequestMiddleware($container->get('request-middleware.csrf.admin'));;

    // Admin Api
    $adminApi = new Controller('api');
    $adminApiUserunfo = new Controller(
        'userinfo',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Api\Userinfo\DefaultAction')
    );
    $adminApi->setChild($adminApiUserunfo);

    // Admin Audio
    $adminAudio = new Controller('audio');
    $adminAudioDelete = new Controller(
        'delete',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Audio\Delete\DefaultAction'),
        null,
        'audio_delete'
    );
    $adminAudioUpdate = new Controller(
        'update',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Audio\Update\DefaultAction'),
        null,
        'audio_update'
    );
    $adminAudioNew = new Controller(
        'new',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Audio\New\DefaultAction'),
        null,
        'audio_new'
    );
    $adminAudioTranslate = new Controller('translate', false, null, null, 'audio_translate');
    $adminAudioTranslateNew = new Controller(
        'new',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Audio\Translate\New\DefaultAction'),
        null,
        'audio_translate_new'
    );
    $adminAudioTranslateUpdate = new Controller(
        'update',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Audio\Translate\Update\DefaultAction'),
        null,
        'audio_translate_update'
    );
    $adminAudioTranslateDelete = new Controller(
        'delete',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Audio\Translate\Delete\DefaultAction'),
        null,
        'audio_translate_delete'
    );
    $adminAudioTranslate
    ->setChild($adminAudioTranslateDelete)
    ->setChild($adminAudioTranslateNew)
    ->setChild($adminAudioTranslateUpdate);

    $adminAudio->addRequestMiddleware($container->get('request-middleware.csrf.admin'));
    $adminAudio
    ->setChild($adminAudioDelete)
    ->setChild($adminAudioNew)
    ->setChild($adminAudioTranslate)
    ->setChild($adminAudioUpdate);

    // Admin Author
    $adminAuthor = new Controller('author');
    $adminAuthorUpdate = new Controller(
        'update',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Author\Update\DefaultAction'),
        null,
        'author_update'
    );
    $adminAuthorNew = new Controller(
        'new',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Author\New\DefaultAction'),
        null,
        'author_new'
    );
    $adminAuthorDelete = new Controller(
        'delete',
        false,
        $container->get('Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Author\Delete\DefaultAction'),
        null,
        'author_delete'
    );
    $adminAuthor
    ->setChild($adminAuthorUpdate)
    ->setChild($adminAuthorNew)
    ->setChild($adminAuthorDelete)
    ->addRequestMiddleware($container->get('request-middleware.csrf.admin'));
    
    // Admin Banner
    $adminBanner = new Controller('banner');
    $adminBannerUpdate = new Controller(
        'update',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Banner\Update\DefaultAction'),
        null,
        'banner_update'
    );
    $adminBannerNew = new Controller(
        'new',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Banner\New\DefaultAction'),
        null,
        'banner_new'
    );
    $adminBanner
    ->setChild($adminBannerNew)
    ->setChild($adminBannerUpdate)
    ->addRequestMiddleware($container->get('request-middleware.csrf.admin'));

    // Admin Category
    $adminCategory = new Controller('category');
    $adminCategoryDelete = new Controller(
        'delete',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Category\Delete\DefaultAction'),
        null,
        'category_delete'
    );
    $adminCategoryNew = new Controller(
        'new',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Category\New\DefaultAction'),
        null,
        'category_new'
    );
    $adminCategoryUpdate = new Controller(
        'update',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Category\Update\DefaultAction'),
        null,
        'category_update'
    );
    $adminCategory
    ->setChild($adminCategoryDelete)
    ->setChild($adminCategoryNew)
    ->setChild($adminCategoryUpdate)
    ->addRequestMiddleware($container->get('request-middleware.csrf.admin'));

    // Admin Image
    $adminImage = new Controller('image');
    $adminImageUpdate = new Controller(
        'update',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Image\Update\DefaultAction'),
        null,
        'image_update'
    );
    $adminImageNew = new Controller(
        'new',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Image\New\DefaultAction'),
        null,
        'image_new'
    );
    $adminImageDelete = new Controller(
        'delete',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Image\Delete\DefaultAction'),
        null,
        'image_delete'
    );
    $adminImage->addRequestMiddleware($container->get('request-middleware.csrf.admin'));
    $adminImage
    ->setChild($adminImageUpdate)
    ->setChild($adminImageNew)
    ->setChild($adminImageDelete);

    // Admin Image Cache
    $adminImagecache = new Controller('imagecache', false);
    $adminImagecacheClear = new Controller(
        'clear',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Imagecache\Clear\DefaultAction')
    );
    $adminImagecacheClear->addRequestMiddleware($container->get('request-middleware.csrf.admin'));
    $adminImagecache->setChild($adminImagecacheClear);

    // Admin Logout
    $adminLogout = new Controller(
        'logout',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Logout\DefaultAction'),
        null,
        'admin_logout'
    );
    
    // Admin Translate
    $adminTranslate = new Controller('translate');
    $adminTranslateUpdate = new Controller(
        'update',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Translate\Update\DefaultAction'),
        null,
        'translate_update'
    );
    $adminTranslateNew = new Controller(
        'new',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Translate\New\DefaultAction'),
        null,
        'translate_new'
    );
    $adminTranslateDelete = new Controller(
        'delete',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Translate\Delete\DefaultAction'),
        null,
        'translate_delete'
    );
    $adminTranslate
    ->setChild($adminTranslateUpdate)
    ->setChild($adminTranslateNew)
    ->setChild($adminTranslateDelete)
    ->addRequestMiddleware($container->get('request-middleware.csrf.admin'));

    $admin->setChild($adminLogout)
    ->setChild($adminArticle)
    ->setChild($adminApi)
    ->setChild($adminAudio)
    ->setChild($adminAuthor)
    ->setChild($adminBanner)
    ->setChild($adminCategory)
    ->setChild($adminImage)
    ->setChild($adminImagecache)
    ->setChild($adminTranslate);

    $root->setChild($auth)
    ->setChild($admin)
    ->setChild($api)
    ->setChild($logout);

    return $root;
};