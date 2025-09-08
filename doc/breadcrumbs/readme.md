# Breadcrumbs

The website automatically generates `breadcrumbs` for each page.
They are not displayed on the `home page`. On all other pages, you can see them `between the navigation menu and the content`.

The generation is carried out using a `view class`, in which everything is `already provided`. Thus, to display it on the external part of the site, you just need to use the functionality.

Classes responsible for generating breadcrumbs:

- [Breadcrumb](https://github.com/Romchik38/server/blob/master/src/Http/Controller/Mappers/Breadcrumb/Breadcrumb.php)
- [BreadcrumbControllerTrait](https://github.com/Romchik38/server/blob/master/src/Http/Views/Traits/BreadcrumbControllerTrait.php)
- [Site2 View](./../../app/code/Infrastructure/Http/Views/Html/Site2TwigControllerViewLayout.php)

## How it works

1. [Site2 View](./../../app/code/Infrastructure/Http/Views/Html/Site2TwigControllerViewLayout.php) class is created, based on `AbstractControllerView`, which is responsible for HTML generation. The created `Site2 View` class independently includes the pre-prepared `BreadcrumbControllerTrait` for generating breadcrumbs.
2. In order to use `BreadcrumbControllerTrait`, `Site2 View` must receive a `BreadcrumbInterface` in its constructor. This is needed to know which URLs to use during generation - with or without the root path. So you have to prepare the corresponding `Breadcrumb` class yourself. `Site2` uses it with [DynamicRoot](https://github.com/Romchik38/server/tree/master/src/Http/Routers/Handlers/DynamicRoot)
3. Inside Site2 View's `beforeRender` function generated `breadrumb` var to use inside twig template.
