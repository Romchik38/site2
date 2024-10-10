# Readme

- Template folder parts
- Path to base layout
- Path to action layout

## Template folder parts

Template folder consists of 3 parts:

- **Main** part - */code/Views/Html/Templates*.
- **Middle** part for base layout or controller. Something Like this *base.twig* and *controllers/root*.
- **Last** part for default or dynamic routes. Looks like */default/index.twig*, */dynamic/about*, etc.

Examples:

- /code/Views/Html/Templates/base.twig
- /code/Views/Html/Templates/controllers/root/default/index.twig

## Path to base layout

1. When `TwigView` class is created, it receives `Twig\Environment` with `\Twig\Loader\FilesystemLoader` inside. The `Loader` has *main* part (#1) which was provided during it creation.
2. `TwigView` has property `layoutPath` with default value *base.twig* (#2). You can change it by passing in the construct method.
3. During `build` method execution template will be rendered with values #1 and #2.

For example - /code/Views/Html/Templates/base.twig

Where:

| path                        |  description                                    |
|-----------------------------|-------------------------------------------------|
| /code/Views/Html/Templates  |  from `Loader`                                  |
| /                           |  added by `TwigView`                            |
| base.twig                   |  default value of the `TwigView->layoutPath`    |

## Path to action layout

1. `TwigView` has property `controllerPath` with default value *controllers*. You can change it by passing in the construct method.
2. During `build` method execution *controllers* will be concatenated with *controller name part* and *action name part*

*controller name part* - the name of the controller, given at creation. For root controller it will be *root*.

*action name part* - it will be */default/index.twig* for default action and */dynamic/action_name.twig* for dynamuc action. Where *action_name* is the dynamic action.

For example - controllers/root/default/index.twig

where:

| path                        |  description                                    |
|-----------------------------|-------------------------------------------------|
| controllers                 |  default value of the `TwigView->controllerPath`|
| /                           |  added by `TwigView`                            |
| root                        |  controller name (*root* for root controller)   |
| /default/index.twig         |  path to default action layout                  |

How it works:

1. Twig will render base template */code/Views/Html/Templates/base.twig*
2. Inside it, you can include controller layout with `content_template` variable which will be controllers/root/default/index.twig

    base.twig:

    ```twig
        {% include content_template %}
    ```

3. Twig can include it, because it has *main* part */code/Views/Html/Templates*
