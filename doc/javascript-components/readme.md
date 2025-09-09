# Javascript components

For the external part of the site (frontend), the site has its own JavaScript developments.

They consist of the following parts:

- components for working with DOM elements
- modules for working with important parts of the site
- modules for corresponding site blocks: articles, audio, and so on.

## Components for working with DOM elements

General components for working with DOM elements are located here. They are based on Javascript classes for easy inheritance. You can manage a single component using [Component](./../../public/http/media/js/modules/components/component.js) or a group of components using [ComponentCollection](./../../public/http/media/js/modules/components/componentCollection.js).

The components inherit from [EventEmitter](./../../public/http/media/js/modules/utils/eventEmitter.js) for easy event management.

When developing the components, attention was paid only to the `requirements of Site2`. Therefore, if you don't see much functionality in them, it is a result of the lack of requirements.

The `components` can be used for work on any website. They are not specifically tied to Site2.

## Modules for working with important parts of the site

You can find modules for working with important parts of the site here. They include [UrlBuilder](./../../public/http/media/js/modules/urlbuilder), [make request](./../../public/http/media/js/modules/utils/make-request) utilities, the aforementioned [EventEmitter](./../../public/http/media/js/modules/utils/eventEmitter.js), and [UrlBuilder Site2](./../../public/http/media/js/modules/utils/urlbuilder.js).

`UrlBuilder`, `make request`, `EventEmitter` are not tied to site2 and can be used on another website.

## Modules for corresponding site blocks

You can find the modules of the corresponding blocks in the [frontend](./../../public/http/media/js/frontend) directory. These files are closely linked with Site2 and require significant changes to be used on another resource.

The modules for the administrative part are located in the [admin](./../../public/http/media/js/admin) directory.

The modules are mainly separated by controllers, but not always.
