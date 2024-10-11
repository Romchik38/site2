# Readme

1. Init
2. Variables
3. Include

## 1. Init

`TwigView` renders *base.twig* layout with given to `Loader` path.

So you must

1. Create a folder and give it to `Loader()`
2. Create a file *base.twig* in this folder and place html and twig code you like

*base.twig* is a default value. You can change it by passing other value to `__construct` method `TwigView` class.

## 2. Variables

`TwigView` injects mandatory and optional variables.

### mandatory variables

|   Variable                |   Description                     |
|---------------------------|-----------------------------------|
|data                       |   Controller DTO                  |
|meta_data                  |   Meta data from TwigView         |
|template_controller_name   |   controller name ( root for / )  |
|template_action_type       |   dynamic_action / action         |

### optional variables

|   Variable                |   Description                     |
|---------------------------|-----------------------------------|
|template_action_name       |   dynamic action name             |
|translate                  |   translate service               |

## 3. Include

Inside *base.twig* you can create a paths to the files using the provided variables.

Example:

- main path give to `Loader` is *app/view/templates*
- template_controller_name is *posts*
- template_action_type is *action*

1. create *index.twig* inside *app/view/templates/posts/action/*
2. use twig `include` to render it

```twig
{# use this inside base.twig to create a controller_template variable
    template_controller_name, 
    template_action_type, 
    'index.twig' 
#}
{% include controller_template %}
````
