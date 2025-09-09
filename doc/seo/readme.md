# SEO

- robots.txt
- images
- metatags
- pagespeed

## robots.txt

By default, [robots.txt](./../../public/http/robots.txt) is configured to disallow all robots. You can edit this file to change default behavior.

## images

Images are adaptive. The best and largest image is shown to the search engine bot. For the user, the browser loads the optimal size depending on the device.

Approximation of the HTML code block.

```html
<picture>
    <source media="(max-width: 636px)" srcset="/img.php?id=136&amp;type=webp&amp;width=576&amp;height=384">
    <source media="(max-width: 992px)" srcset="/img.php?id=136&amp;type=webp&amp;width=720&amp;height=480">
    <source media="(min-width: 992px)" srcset="/img.php?id=136&amp;type=webp&amp;width=1080&amp;height=720">
    <img class="img-fluid" src="/media/img/articles/JxqWrVdTDi308pxjS6ts.webp" alt="City with a square and a large building with the inscription PHP on top">
</picture>
```

Thanks to an [image converter](./../Image_Converter/01_readme.md), it's possible to get the same picture in different sizes.

## Metatags

The site generates unique meta tag with  name `title`, `description`, and `h1` tag for each page.

## Pagespeed

@todo Need test
