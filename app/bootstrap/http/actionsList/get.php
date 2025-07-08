<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Server\Http\Controller\ControllerInterface;
use Romchik38\Server\Http\Controller\Mappers\ControllerTree\ControllerTreeInterface;
use Romchik38\Server\Http\Controller\Controller;

return function (Container $container): ControllerInterface {
    /** API */
    $api = new Controller('api');

    /** SITEMAP */
    $sitemap = new Controller(
        'sitemap',
        true,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Sitemap\DefaultAction')
    );

    /** SERVER-ERROR example */
    $serverErrorExample = new Controller(
        'server-error-example',
        true,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\ServerErrorExample\DefaultAction')
    );

    /** ARTICLE */
    $article = new Controller(
        'article',
        true,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Article\DefaultAction'),
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Article\DynamicAction')
    );

    /** ADMIN */
    $admin = new Controller(
        'admin',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\DefaultAction')
    );
    $admin->addRequestMiddleware($container->get('\Romchik38\Site2\Infrastructure\Http\RequestMiddlewares\Admin\AdminLoginMiddleware'));

    $adminArticle = new Controller(
        'article',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\DefaultAction'),
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\DynamicAction'),
        'admin_article'
    );
    $adminArticleNew = new Controller(
        'new',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\New\DefaultAction'),
        null,
        'article_new'
    );
    $adminArticleMostVisited = new Controller(
        'most_visited',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\MostVisited\DefaultAction'),
        null,
        'article_most_visited'
    );
    $adminArticle
    ->setChild($adminArticleMostVisited)
    ->setChild($adminArticleNew);

    $adminAudio = new Controller(
        'audio',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\DefaultAction'),
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\DynamicAction')
    );
    $adminAudioNew = new Controller(
        'new',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\New\DefaultAction'),
        null,
        'audio_new'
    );
    $adminAudioTranslate = new Controller(
        'translate',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\Translate\DefaultAction'),
        null,
        'audio_translate'
    );
    $adminAudioTranslateNew = new Controller(
        'new',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\Translate\New\DefaultAction'),
        null,
        'audio_translate_new'
    );
    $adminAudioTranslate->setChild($adminAudioTranslateNew);
    
    $adminAudio
    ->setChild($adminAudioNew)
    ->setChild($adminAudioTranslate);

    $adminAuthor = new Controller(
        'author',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author\DefaultAction'),
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author\DynamicAction')
    );
    $adminAuthorNew = new Controller(
        'new',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author\New\DefaultAction'),
        null,
        'author_new'
    );
    $adminAuthor->setChild($adminAuthorNew);

    // Admin Banner
    $adminBanner = new Controller(
        'banner',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Banner\DefaultAction'),
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Banner\DynamicAction')
    );
    $adminBannerNew = new Controller(
        'new',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Banner\New\DefaultAction'),
        null,
        'banner_new'
    );
    $adminBanner->setChild($adminBannerNew);

    // Admin Category
    $adminCategory = new Controller(
        'category',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Category\DefaultAction'),
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Category\DynamicAction'),
        'admin_category'
    );
    $adminCategoryNew = new Controller(
        'new',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Category\New\DefaultAction'),
        null,
        'admin_category_new'
    );
    $adminCategory->setChild($adminCategoryNew);

    // Admin Imagecache
    $adminImagecache = new Controller(
        'imagecache',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Imagecache\DefaultAction')
    );

    // Admin Image
    $adminImage = new Controller(
        'image',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image\DefaultAction'),
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image\DynamicAction')
    );
    $adminImageNew = new Controller(
        'new',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image\New\DefaultAction'),
        null,
        'image_new'
    );
    $adminImage->setChild($adminImageNew);

    // Admin Language
    $adminLanguage = new Controller(
        'language',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Language\DefaultAction')
    );
    
    // Admin Translate
    $adminTranslate = new Controller(
        'translate',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Translate\DefaultAction'),
        $container->get('\\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Translate\DynamicAction')
    );
    $admintranslateNew = new Controller(
        'new',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Translate\New\DefaultAction'),
        null,
        'translate_new'
    );
    $adminTranslate->setChild($admintranslateNew);

    // Admin Users
    $adminUsers = new Controller(
        'users',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Users\DefaultAction')
    );
    $adminUsers->addRequestMiddleware($container->get('Romchik38\Site2\Infrastructure\Http\RequestMiddlewares\Admin\AdminRolesMiddleware'));

    $admin
    ->setChild($adminAudio)
    ->setChild($adminArticle)
    ->setChild($adminAuthor)
    ->setChild($adminBanner)
    ->setChild($adminCategory)
    ->setChild($adminImagecache)
    ->setChild($adminImage)
    ->setChild($adminLanguage)
    ->setChild($adminTranslate)
    ->setChild($adminUsers);
    
    /** CATEGORY */
    $category = new Controller(
        'category',
        true,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Category\DefaultAction'),
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Category\DynamicAction')
    );

    /** REGISTER */
    $register = new Controller(
        'register', 
        true,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Register\DefaultAction')
    );

    /** LOGIN */
    $login = new Controller(
        'login', 
        true,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Login\DefaultAction')
    );
    $loginAdmin = new Controller(
        'admin',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Login\Admin\DefaultAction'),
        null,
        'login_admin'
    );
    $login->setChild($loginAdmin);
    
    /** ROOT */
    $root = new Controller(
        ControllerInterface::ROOT_NAME,
        true,
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Root\DefaultAction'),
        $container->get('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Root\DynamicAction'),
    );

    $root
        ->setChild($api)
        ->setChild($article)
        ->setChild($admin)
        ->setChild($category)
        ->setChild($login)
        ->setChild($register)
        ->setChild($sitemap)
        ->setChild($serverErrorExample);
    return $root;
};