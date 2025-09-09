# Readme

Site2 uses `Twig` to generate the HTML code. All files related to the display are located in the [Views directory](./../../app/code/Infrastructure/Http/Views/).

Classes responsible for code generation:

- [Site2TwigControllerViewLayout](./../../app/code/Infrastructure/Http/Views/Html/Site2TwigControllerViewLayout.php) — for almost the entire site.
- [TwigSingleView](./../../app/code/Infrastructure/Http/Views/Html/TwigSingleView.php) — for displaying single pages that are not involved in request routing.

These classes receive Twig settings, along with additional settings specifically for this View.
Each `HTTP action` has access to the corresponding `view` and initiates the HTML generation process.

The mentioned classes inject dependencies into the code template that are needed for the program to build the HTML code. `Common dependencies` can be found by studying the `beforeRender` and `build` functions.

`Dependencies that are different` for various templates are passed using [Site2Metadata](./../../app/code/Infrastructure/Http/Views/Html/Site2Metadata.php).

## Templates

Templates are located in the [Template](./../../app/code/Infrastructure/Http/Views/Html/Templates) directory.

In Site2, `3 types of templates` are used:

- frontend
- admin
- not found

The `frontend` and `admin` templates are `dynamic` and built on a routing system. The `not found` template is a static single-page template.

All of them are built on main template files that are extended:

- `frontend` and `not found` are based on [base_layouts.twig](app/code/Infrastructure/Http/Views/Html/Templates/base_layouts.twig)
- `admin` is based on [base_admin_layouts.twig](app/code/Infrastructure/Http/Views/Html/Templates/base_admin_layouts.twig).

The main files differ insignificantly from each other.

### Dynamic template

The `name` of the directories inside the templates is related to the `name of the controller` and the `type of action`.

For example, to find the `main page template`, you should start from the name of the action that processes it and its controller. The processing is handled by the [DefaultAction](./../../app/code/Infrastructure/Http/Actions/GET/Root/DefaultAction.php), which belongs to the [root controller](./../../app/bootstrap/http/actionsList/get.php).

According to the rules of path construction within the view, it will be as follows: `controllers` + `root` + `default_action` + `index.twig`, where `controllers` and `index.twig` are constants.

When adding a new controller, `you must add the corresponding directories and the index.twig` file, otherwise an `error will occur`.
