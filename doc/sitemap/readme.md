# Sitemap

There is a `sitemap` on the website. You can view it at the web address - `/sitemap`.
The `sitemap` is generated automatically based on `controllers` that have `public` status.

Several classes are responsible for the generation:

- [ControllerTree](https://github.com/Romchik38/server/blob/master/src/Http/Controller/Mappers/ControllerTree/ControllerTree.php) - build a controller tree
- [LinkTree](https://github.com/Romchik38/server/blob/master/src/Http/Controller/Mappers/LinkTree/LinkTree.php) - map the controller tree to a link tree.
- [SitemapLinkTreeToHtml](./../../app/code/Infrastructure/Http/Views/Html/Classes/SitemapLinkTreeToHtml.php) - map the link tree to html.

## How it works

1. The [sitemap action](./../../app/code/Infrastructure/Http/Actions/GET/Sitemap/DefaultAction.php) class passes link to the controller to the `SitemapLinkTreeToHtml`.
2. `SitemapLinkTreeToHtml` uses both `ControllerTree` and `LinkTree` to generate html.
